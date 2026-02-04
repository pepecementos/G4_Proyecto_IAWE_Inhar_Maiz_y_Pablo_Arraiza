<?php
    include "includes/funciones.php";

    // Logout
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        redirigir('index.php');
    }

    // Proceso de login
    if (isset($_POST['cuenta'])) {
        $username = trim($_POST['username'] ?? '');
        $passwd = $_POST['passwd'] ?? '';
        // validar campos vacíos
        $errors = [];
        if ($username === '') $errors['username'] = 'El usuario es obligatorio.';
        if ($passwd === '') $errors['passwd'] = 'La contraseña es obligatoria.';
        if (!empty($errors)) {
            set_form_errors($errors);
            set_old(['username' => $username]);
            redirigir('index.php');
        }
        // validar credenciales
        if (validar_credenciales($username, $passwd)) {
            $_SESSION['usuario'] = $username;
            clear_old();
            set_flash('exito', '¡Bienvenido, ' . htmlspecialchars($username) . '!');
            redirigir('index.php');
        } else {
            set_form_errors(['passwd' => 'Usuario o contraseña incorrectos.']);
            set_old(['username' => $username]);
            redirigir('index.php');
        }
    }

    // Proceso de registro
    if (isset($_POST['crear'])) {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['mail'] ?? '');
        $p1 = $_POST['passwd'] ?? '';
        $p2 = $_POST['passwd2'] ?? '';

        $errors = [];
        if ($username === '') $errors['username'] = 'Nombre de usuario obligatorio.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['mail'] = 'Correo electrónico no válido.';
        if ($p1 === '') $errors['passwd'] = 'Contraseña obligatoria.';
        if ($p1 !== $p2) $errors['passwd2'] = 'Las contraseñas no coinciden.';

        if (!empty($errors)) {
            set_form_errors($errors);
            set_old(['username' => $username, 'mail' => $email]);
            redirigir('index.php?page=registro');
        }

        $res = registrar_usuario($username, $email, $p1);
        if (!$res['ok']) {
            // registrar_usuario ya devuelve mensaje general; lo asociamos al campo username si detectamos duplicado
            $errField = (stripos($res['msg'], 'nombre de usuario') !== false) ? 'username' : 'general';
            if ($errField === 'username') {
                set_form_errors(['username' => $res['msg']]);
            } else {
                set_form_errors(['general' => $res['msg']]);
            }
            set_old(['username' => $username, 'mail' => $email]);
            redirigir('index.php?page=registro');
        }

        // Registro OK: iniciar sesión automáticamente
        $_SESSION['usuario'] = $username;
        clear_old();
        set_flash('exito', 'Cuenta creada. Bienvenido, ' . htmlspecialchars($username) . '!');
        redirigir('index.php');
    }

    // Determinar página y mostrar cabecera
    $pagina = $_GET['page'] ?? 'inicio';
    $paginaActiva = $pagina;
    include "includes/cabecera.php";

    // Si no está logueado y no está en registro, mostrar el login
    if (!usuario_autenticado() && $pagina !== 'registro') {
        include "vistas/login.php";
        exit();
    }

    // Bar de contenido
    if ($pagina == "inicio"){
        include "vistas/inicio.php";
    } elseif ($pagina == "animes"){
        include "vistas/animes.php";
    } elseif ($pagina == "mangas"){
        include "vistas/mangas.php";
    } elseif ($pagina == "anime"){
        include "vistas/anime.php";    } elseif ($pagina == "manga"){
        include "vistas/manga.php";    } elseif ($pagina == "tienda"){
        include "vistas/tienda.php";
    } elseif ($pagina == "areapersonal"){
        include "vistas/areaPersonal.php";
    } elseif ($pagina == "registro") {
        include "vistas/registro.php";
    } else {
        // Página no permitida: mostrar 404 sin usar función central
        http_response_code(404);
        $errorMessage = 'La página que buscas no existe.';
        include "vistas/error404.php";
        exit();
    }

    include "includes/pie.php";

?>