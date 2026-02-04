<?php
// vistas/anime.php
require_once __DIR__ . '/../includes/funciones.php';

$titulo = trim($_GET['anime'] ?? '');
if ($titulo === '') {
  http_response_code(404);
  echo "<div class='panel'>No se especificó el anime.</div>";
  exit();
}

$capitulos = obtener_capitulos_por_anime($titulo);

?>

<section class="hero">
  <div class="hero-inner">
    <div>
      <h1><?= htmlspecialchars($titulo) ?></h1>
      <p>Listado de capítulos (demo). Puedes enlazar cada capítulo a un reproductor o página individual.</p>
      <div class="quick">
        <a class="btn" href="index.php?page=animes<?php echo $usuario?>">Volver</a>
        <a class="btn primary" href="index.php?page=areaPersonal<?php echo $usuario?>">Guardar (demo)</a>
      </div>
    </div>
    <div class="badges">
      <div class="badge"><strong><?= count($capitulos) ?></strong> capítulos</div>
    </div>
  </div>
</section>

<section class="section">
  <div class="section-head">
    <div>
      <h2>Capítulos</h2>
      <p>Selecciona un capítulo para ver más detalles (demo).</p>
    </div>
  </div>

  <div class="grid">
    <?php foreach($capitulos as $c): ?>
      <a class="card" href="#">
        <div class="thumb">
          <span class="chip"><?= htmlspecialchars('Episodio ' . $c['episodio']) ?></span>
        </div>
        <div class="card-body">
          <h3 class="card-title"><?= htmlspecialchars($c['titulo']) ?></h3>
          <div class="meta">
            <span>Ver</span>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>
