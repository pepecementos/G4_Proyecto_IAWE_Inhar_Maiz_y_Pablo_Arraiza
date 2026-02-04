<?php

// includes/funciones.php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) session_start();

// Conexión a BD (PDO)
require_once __DIR__ . '/db.php';

// Mostrar mensajes inmediatos (no persistentes)
function mostrar_mensaje($tipo, $mensaje) {
    echo "<div class='mensaje mensaje-$tipo'>" . htmlspecialchars($mensaje) . "</div>";
}

// Flash messages (persisten en sesión hasta mostrarse)
function set_flash($tipo, $mensaje) {
    $_SESSION['flash'] = ['tipo' => $tipo, 'mensaje' => $mensaje];
}
function mostrar_flash() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        echo "<div class='mensaje mensaje-" . htmlspecialchars($f['tipo']) . "'>" . htmlspecialchars($f['mensaje']) . "</div>";
        unset($_SESSION['flash']);
    }
}

// Helpers para errores por campo y valores antiguos
function set_form_errors(array $errors) {
    $_SESSION['form_errors'] = $errors;
}
function get_form_errors(): array {
    $errors = $_SESSION['form_errors'] ?? [];
    unset($_SESSION['form_errors']);
    return $errors;
}
function set_old(array $old) {
    $_SESSION['old'] = $old;
}
function old(string $field, $default = ''): string {
    $v = $_SESSION['old'][$field] ?? $default;
    return htmlspecialchars((string) $v);
}
function clear_old() {
    unset($_SESSION['old']);
}
function display_field_error(string $field): void {
    $errors = $_SESSION['form_errors'] ?? [];
    if (isset($errors[$field])) {
        echo '<div class="field-error">' . htmlspecialchars($errors[$field]) . '</div>';
    }
}

// Redirección
function redirigir($url) {
    header("Location: $url");
    exit();
}
// --- Carrito de compras en sesión ---
function carrito_agregar($producto, $precio, $cantidad = 1) {
    if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];
    if (isset($_SESSION['carrito'][$producto])) {
        $_SESSION['carrito'][$producto]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$producto] = [
            'producto' => $producto,
            'precio' => $precio,
            'cantidad' => $cantidad
        ];
    }
}

function carrito_quitar($producto) {
    if (isset($_SESSION['carrito'][$producto])) {
        unset($_SESSION['carrito'][$producto]);
    }
}

function carrito_listar() {
    return $_SESSION['carrito'] ?? [];
}

function carrito_vaciar() {
    unset($_SESSION['carrito']);
}

// 3. Comprobar autenticación (ahora por sesión)
function usuario_autenticado(): bool {
    return isset($_SESSION['usuario']) && $_SESSION['usuario'] !== '';
}

// Registro de usuario (con hash de contraseña)
function registrar_usuario(string $username, string $email, string $password): array {
    $username = trim($username);
    $email = trim($email);

    if ($username === '' || $password === '') {
        return ['ok' => false, 'msg' => 'Usuario y contraseña son obligatorios.'];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['ok' => false, 'msg' => 'Correo electrónico no válido.'];
    }

    $pdo = get_db();
    // ¿Existe el usuario?
    $stmt = $pdo->prepare('SELECT id_usuario FROM usuarios WHERE nombre_usuario = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        return ['ok' => false, 'msg' => 'El nombre de usuario ya existe.'];
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Comprobar si la columna 'email' existe en la tabla (compatibilidad con BD antigua)
    $hasEmail = false;
    try {
        $colStmt = $pdo->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'usuarios' AND COLUMN_NAME = 'email'");
        $colStmt->execute([DB_NAME]);
        $hasEmail = (bool) $colStmt->fetch();
    } catch (PDOException $e) {
        // Si falla la comprobación, continuamos asumiendo que no existe
        $hasEmail = false;
    }

    try {
        if ($hasEmail) {
            $stmt = $pdo->prepare('INSERT INTO usuarios (nombre_usuario, contrasena, email) VALUES (?, ?, ?)');
            $stmt->execute([$username, $hash, $email]);
        } else {
            // Inserción sin la columna email para bases de datos antiguas
            $stmt = $pdo->prepare('INSERT INTO usuarios (nombre_usuario, contrasena) VALUES (?, ?)');
            $stmt->execute([$username, $hash]);
        }
    } catch (PDOException $e) {
        return ['ok' => false, 'msg' => 'Error al crear la cuenta: ' . $e->getMessage() . '. Si tu BD es antigua, ejecuta: ALTER TABLE usuarios ADD COLUMN email VARCHAR(100) DEFAULT NULL;'];
    }

    return ['ok' => true, 'id' => $pdo->lastInsertId()];
}

// Validar credenciales
function validar_credenciales(string $username, string $password): bool {
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT contrasena FROM usuarios WHERE nombre_usuario = ?');
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    if (!$row) return false;
    $hash = $row['contrasena'];
    // Normal case: contraseña hasheada
    if (password_verify($password, $hash)) return true;
    // Fallback: contraseña almacenada en claro (migración automática)
    if ($password === $hash) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $upd = $pdo->prepare('UPDATE usuarios SET contrasena = ? WHERE nombre_usuario = ?');
        $upd->execute([$newHash, $username]);
        return true;
    }
    return false;
}

function obtener_usuario_por_nombre(string $username): ?array {
    $pdo = get_db();
    try {
        // Intentamos obtener email si existe
        $stmt = $pdo->prepare('SELECT id_usuario, nombre_usuario, email FROM usuarios WHERE nombre_usuario = ?');
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        if ($row) return $row;
    } catch (PDOException $e) {
        // Si la columna 'email' no existe en la tabla, hacemos un fallback sin email
        if (strpos($e->getMessage(), 'Unknown column') !== false || $e->getCode() === '42S22') {
            $stmt = $pdo->prepare('SELECT id_usuario, nombre_usuario FROM usuarios WHERE nombre_usuario = ?');
            $stmt->execute([$username]);
            $row = $stmt->fetch();
            if ($row) {
                $row['email'] = null;
                return $row;
            }
            return null;
        }
        // Re-lanzar otras excepciones inesperadas
        throw $e;
    }
    return null;
}

// Datos: tendencias y últimos mangas (centralizados para reutilizar)
function obtener_trending(): array {
    return [
      ['titulo'=>'Jujutsu Kaisen', 'tipo'=>'Anime', 'estado'=>'En emisión', 'tag1'=>'Acción', 'tag2'=>'Shonen'],
      ['titulo'=>'Frieren', 'tipo'=>'Anime', 'estado'=>'Finalizado', 'tag1'=>'Fantasía', 'tag2'=>'Aventura'],
      ['titulo'=>'Solo Leveling', 'tipo'=>'Anime', 'estado'=>'Temporada 2', 'tag1'=>'Acción', 'tag2'=>'RPG'],
      ['titulo'=>'One Piece', 'tipo'=>'Anime', 'estado'=>'En emisión', 'tag1'=>'Aventura', 'tag2'=>'Largo'],
    ];
}

function obtener_ultimos_mangas(): array {
    return [
      ['titulo'=>'Chainsaw Man', 'tipo'=>'Manga', 'estado'=>'Cap. 154', 'tag1'=>'Oscuro', 'tag2'=>'Acción'],
      ['titulo'=>'Blue Lock', 'tipo'=>'Manga', 'estado'=>'Cap. 289', 'tag1'=>'Deporte', 'tag2'=>'Rivalidad'],
      ['titulo'=>'Oshi no Ko', 'tipo'=>'Manga', 'estado'=>'Cap. 141', 'tag1'=>'Drama', 'tag2'=>'Industria'],
      ['titulo'=>'Kaiju No. 8', 'tipo'=>'Manga', 'estado'=>'Cap. 118', 'tag1'=>'Monstruos', 'tag2'=>'Acción'],
    ];
}

function generar_capitulos_deterministas(string $titulo, int $min = 8, int $max = 26, string $clave = 'episodio'): array {
    // Generación determinista basada en hash para que no cambie entre peticiones
    $seed = hexdec(substr(md5(mb_strtolower($titulo)), 0, 8));
    $count = $min + ($seed % ($max - $min + 1));
    $caps = [];
    for ($i = 1; $i <= $count; $i++) {
        $caps[] = [$clave => $i, 'titulo' => ucfirst(($clave === 'episodio' ? 'Episodio' : 'Capítulo') . " $i")];
    }
    return $caps;
}

function obtener_capitulos_por_anime(string $titulo): array {
    $t = mb_strtolower(trim($titulo));

    // Overrides / fallback determinista
    $overrides = [
        'attack on titan' => [
            ['episodio'=>1, 'titulo'=>'Aos ataques de los titanes'],
            ['episodio'=>2, 'titulo'=>'La tormenta del distrito'],
            ['episodio'=>3, 'titulo'=>'Aurora de la exploración'],
        ],
        'demon slayer' => [
            ['episodio'=>1, 'titulo'=>'Crueldad y sangre'],
            ['episodio'=>2, 'titulo'=>'Solo un instante'],
            ['episodio'=>3, 'titulo'=>'La marca del cazador'],
        ],
        'jujutsu kaisen' => [
            ['episodio'=>1, 'titulo'=>'El chico maldito'],
            ['episodio'=>2, 'titulo'=>'Intercambio de vida'],
            ['episodio'=>3, 'titulo'=>'La técnica prohibida'],
        ],
        'one piece' => [
            ['episodio'=>1, 'titulo'=>'Yo seré el rey de los piratas'],
            ['episodio'=>2, 'titulo'=>'Entrando al mar'],
            ['episodio'=>3, 'titulo'=>'La primera aventura'],
        ],
    ];

    if (isset($overrides[$t])) return $overrides[$t];

    return generar_capitulos_deterministas($titulo, 8, 26, 'episodio');
}

function obtener_capitulos_por_manga(string $titulo): array {
    // Fallback determinista para mangas
    return generar_capitulos_deterministas($titulo, 6, 120, 'capitulo');
}

// --- Seguimientos (usuarios siguen animes/mangas) ---------------------------------
function ensure_seguimientos_table(): void {
    $pdo = get_db();
    $sql = "CREATE TABLE IF NOT EXISTS seguimientos (
      id INT AUTO_INCREMENT PRIMARY KEY,
      id_usuario INT NOT NULL,
      tipo ENUM('anime','manga') NOT NULL,
      titulo VARCHAR(255) NOT NULL,
      creado_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY ux_usuario_tipo_titulo (id_usuario, tipo, titulo),
      FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    try {
        $pdo->exec($sql);
    } catch (PDOException $e) {
        // No bloqueamos la ejecución por fallo en la creación automática
    }
}

function seguir_item(int $id_usuario, string $tipo, string $titulo): bool {
    $tipo = mb_strtolower(trim($tipo)) === 'manga' ? 'manga' : 'anime';
    ensure_seguimientos_table();
    $pdo = get_db();
    try {
        $stmt = $pdo->prepare('INSERT IGNORE INTO seguimientos (id_usuario, tipo, titulo) VALUES (?, ?, ?)');
        $stmt->execute([$id_usuario, $tipo, $titulo]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

function dejar_de_seguir(int $id_usuario, string $tipo, string $titulo): bool {
    ensure_seguimientos_table();
    $pdo = get_db();
    $stmt = $pdo->prepare('DELETE FROM seguimientos WHERE id_usuario = ? AND tipo = ? AND titulo = ?');
    $stmt->execute([$id_usuario, $tipo, $titulo]);
    return $stmt->rowCount() > 0;
}

function usuario_siguiendo(int $id_usuario, string $tipo, string $titulo): bool {
    ensure_seguimientos_table();
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT 1 FROM seguimientos WHERE id_usuario = ? AND tipo = ? AND titulo = ? LIMIT 1');
    $stmt->execute([$id_usuario, $tipo, $titulo]);
    return (bool)$stmt->fetchColumn();
}

function obtener_seguimientos_por_usuario(int $id_usuario): array {
    ensure_seguimientos_table();
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT tipo, titulo, creado_at FROM seguimientos WHERE id_usuario = ? ORDER BY creado_at DESC');
    $stmt->execute([$id_usuario]);
    return $stmt->fetchAll();
}

// Helper: obtener metadata de un título buscando en listas disponibles (trending/ultimos)
function obtener_info_titulo(string $titulo): array {
    $t = mb_strtolower(trim($titulo));
    // Buscar en trending
    foreach (obtener_trending() as $it) {
        if (mb_strtolower($it['titulo']) === $t) return $it + ['titulo' => $titulo];
    }
    // Buscar en últimos mangas
    foreach (obtener_ultimos_mangas() as $it) {
        if (mb_strtolower($it['titulo']) === $t) return $it + ['titulo' => $titulo];
    }
    // Fallback: estructura mínima
    return ['titulo' => $titulo, 'tipo' => '', 'estado' => '', 'tag1' => '', 'tag2' => ''];
}
