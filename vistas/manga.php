<?php
// vistas/manga.php
require_once __DIR__ . '/../includes/funciones.php';

$titulo = trim($_GET['manga'] ?? '');
if ($titulo === '') {
  http_response_code(404);
  echo "<div class='panel'>No se especificó el manga.</div>";
  exit();
}

$capitulos = obtener_capitulos_por_manga($titulo);

// Comprobar si el usuario sigue este manga
$u = usuario_autenticado() ? obtener_usuario_por_nombre($_SESSION['usuario']) : null;
$isFollowing = false;
if ($u) $isFollowing = usuario_siguiendo((int)$u['id_usuario'], 'manga', $titulo);

?>

<?php
  $base = 'imagenes/mangas/' . preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($titulo));
  $exts = ['jpg', 'jpeg', 'png', 'webp'];
  $imgPath = 'imagenes/logoAnimeXAI.JPG';
  foreach ($exts as $ext) {
    if (file_exists($base . '.' . $ext)) {
      $imgPath = $base . '.' . $ext;
      break;
    }
  }
?>
<section class="hero">
  <div class="hero-inner" style="display:flex;align-items:center;gap:32px;">
    <div style="flex-shrink:0;">
      <img src="<?= $imgPath ?>" alt="Portada de <?= htmlspecialchars($titulo) ?>" style="width:120px;height:170px;object-fit:cover;border-radius:12px;box-shadow:0 2px 12px #0001;">
    </div>
    <div style="flex:1;">
      <h1><?= htmlspecialchars($titulo) ?></h1>
      <p>Listado de capítulos del manga. Puedes enlazar cada capítulo a un lector o página individual.</p>
      <div class="quick">
        <a class="btn" href="index.php?page=mangas<?php echo $usuario?>">Volver</a>
        <form method="post" style="display:inline">
          <input type="hidden" name="tipo" value="manga">
          <input type="hidden" name="titulo" value="<?= htmlspecialchars($titulo) ?>">
          <?php if ($isFollowing): ?>
            <button class="btn" type="submit" name="dejar_seguir">Dejar de seguir</button>
          <?php else: ?>
            <button class="btn primary" type="submit" name="seguir">Seguir</button>
          <?php endif; ?>
        </form>
      </div>
      <div class="badges">
        <div class="badge"><strong><?= count($capitulos) ?></strong> capítulos</div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="section-head">
    <div>
      <h2>Capítulos</h2>
      <p>Selecciona un capítulo para ver más detalles.</p>
    </div>
  </div>

  <div class="grid">
    <?php foreach($capitulos as $c): ?>
      <a class="card" href="#">
        <div class="thumb">
          <span class="chip"><?= htmlspecialchars('Cap. ' . $c['capitulo']) ?></span>
        </div>
        <div class="card-body">
          <h3 class="card-title"><?= htmlspecialchars($c['titulo']) ?></h3>
          <div class="meta">
            <span>Leer</span>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>
