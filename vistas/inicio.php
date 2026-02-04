
<?php
// vistas/inicio.php
require_once __DIR__ . '/../includes/funciones.php';

$trending = obtener_trending();

$ultimosMangas = obtener_ultimos_mangas();
if (isset($_GET['msg'])) {
    mostrar_mensaje('exito', htmlspecialchars($_GET['msg']));
}
?>

<section class="hero">
  <div class="hero-inner">
    <div>
      <h1>Tu portal de anime y manga</h1>
      <p>
        Interfaz estilo streaming: descubre series, guarda favoritos y sigue capítulos.
        (Por ahora es demo estática, perfecta para ir conectando a BD y APIs).
      </p>
      <div class="quick">
        <a class="btn primary" href="index.php?page=animes<?php echo $usuario?>">Ver animes</a>
        <a class="btn" href="index.php?page=mangas<?php echo $usuario?>">Leer mangas</a>
        <a class="btn" href="index.php?page=tienda<?php echo $usuario?>">Tienda</a>
      </div>
    </div>

    <div class="badges">
      <div class="badge"><strong>✓</strong> Diseño responsive</div>
      <div class="badge"><strong>✓</strong> Vistas separadas</div>
      <div class="badge"><strong>✓</strong> Router con whitelist</div>
      <div class="badge"><strong>✓</strong> Header/Footer en includes</div>
    </div>
  </div>
</section>

<section class="section">
  <div class="section-head">
    <div>
      <h2>Tendencias</h2>
      <p>Lo más visto ahora (ejemplo)</p>
    </div>
    <p><a class="btn" href="index.php?page=animes<?php echo $usuario?>">Explorar</a></p>
  </div>

  <div class="grid">
    <?php foreach($trending as $item): ?>
      <?php
        $tipo = mb_strtolower(trim($item['tipo'] ?? ''));
        if ($tipo === 'anime' || $tipo === 'animé') {
          $link = 'index.php?page=anime&anime=' . urlencode($item['titulo']) . $usuario;
        } elseif ($tipo === 'manga' || strpos($tipo, 'mang') !== false) {
          $link = 'index.php?page=manga&manga=' . urlencode($item['titulo']) . $usuario;
        } else {
          // Fallback: si tiene tag que sugiere manga, vamos a manga; si no, animes
          $maybeManga = mb_stripos($item['tag1'] ?? '', 'manga') !== false || mb_stripos($item['tag2'] ?? '', 'manga') !== false;
          $link = $maybeManga ? ('index.php?page=manga&manga=' . urlencode($item['titulo']) . $usuario) : ('index.php?page=animes' . $usuario);
        }
      ?>
      <a class="card" href="<?= $link ?>">
        <div class="thumb">
          <span class="chip"><?= htmlspecialchars($item["estado"]) ?></span>
        </div>
        <div class="card-body">
          <h3 class="card-title"><?= htmlspecialchars($item["titulo"]) ?></h3>
          <div class="meta">
            <span><?= htmlspecialchars($item["tipo"]) ?></span>
            <span><?= htmlspecialchars($item["tag1"]) ?></span>
            <span><?= htmlspecialchars($item["tag2"]) ?></span>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="section">
  <div class="section-head">
    <div>
      <h2>Últimos mangas</h2>
      <p>Actualizaciones recientes (ejemplo)</p>
    </div>
    <p><a class="btn" href="index.php?page=mangas<?php echo $usuario?>">Ver lista</a></p>
  </div>

  <div class="grid">
    <?php foreach($ultimosMangas as $item): ?>
      <?php $linkM = 'index.php?page=manga&manga=' . urlencode($item['titulo']) . $usuario; ?>
      <a class="card" href="<?= $linkM ?>">
        <div class="thumb">
          <span class="chip"><?= htmlspecialchars($item["estado"]) ?></span>
        </div>
        <div class="card-body">
          <h3 class="card-title"><?= htmlspecialchars($item["titulo"]) ?></h3>
          <div class="meta">
            <span><?= htmlspecialchars($item["tipo"]) ?></span>
            <span><?= htmlspecialchars($item["tag1"]) ?></span>
            <span><?= htmlspecialchars($item["tag2"]) ?></span>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="section">
  <div class="notice">
    <strong>Siguiente paso recomendado</strong>
    <small>
      Conectar estas listas a una BD (MySQL) y renderizar con consultas. Si quieres, te preparo el esquema SQL +
      una capa de acceso con PDO (seguro) y páginas de detalle (anime.php?id=...).
    </small>
  </div>
</section>