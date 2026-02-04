<?php
// vistas/mangas.php
require_once __DIR__ . '/../includes/funciones.php';

$q = trim($_GET["q"] ?? "");

$mangas = [
  ["titulo"=>"Berserk", "tipo"=>"Seinen", "capitulo"=>"Cap. 375", "estado"=>"En publicación", "img"=>"https://cdn.myanimelist.net/images/manga/1/157897.jpg"],
  ["titulo"=>"One Punch Man", "tipo"=>"Shonen", "capitulo"=>"Cap. 203", "estado"=>"En publicación", "img"=>"https://cdn.myanimelist.net/images/manga/3/80661.jpg"],
  ["titulo"=>"Vinland Saga", "tipo"=>"Seinen", "capitulo"=>"Cap. 216", "estado"=>"En publicación", "img"=>"https://cdn.myanimelist.net/images/manga/2/181525.jpg"],
  ["titulo"=>"Haikyuu!!", "tipo"=>"Deporte", "capitulo"=>"Completo", "estado"=>"Finalizado", "img"=>"https://cdn.myanimelist.net/images/manga/3/144325.jpg"],
  ["titulo"=>"Death Note", "tipo"=>"Thriller", "capitulo"=>"Completo", "estado"=>"Finalizado", "img"=>"https://cdn.myanimelist.net/images/manga/2/54425.jpg"],
  ["titulo"=>"Tokyo Revengers", "tipo"=>"Acción", "capitulo"=>"Completo", "estado"=>"Finalizado", "img"=>"https://cdn.myanimelist.net/images/manga/3/220495.jpg"],
];

// Añadir los últimos mangas centralizados (sin duplicados)
$ultimos = obtener_ultimos_mangas();
$existingM = array_map(function($m){ return mb_strtolower($m['titulo']); }, $mangas);
foreach ($ultimos as $u) {
  if (($u['tipo'] ?? '') === 'Manga') {
    $titleLower = mb_strtolower($u['titulo']);
    if (!in_array($titleLower, $existingM)) {
      $mangas[] = [
        'titulo' => $u['titulo'],
        'tipo' => $u['tag1'] ?? '',
        'capitulo' => $u['estado'] ?? '',
        'estado' => $u['estado'] ?? '',
      ];
      $existingM[] = $titleLower;
    }
  }
}

// Añadir los últimos mangas centralizados (sin duplicados)
$ultimos = obtener_ultimos_mangas();
$existingM = array_map(function($m){ return mb_strtolower($m['titulo']); }, $mangas);
foreach ($ultimos as $u) {
  if (($u['tipo'] ?? '') === 'Manga') {
    $titleLower = mb_strtolower($u['titulo']);
    if (!in_array($titleLower, $existingM)) {
      $mangas[] = [
        'titulo' => $u['titulo'],
        'tipo' => $u['tag1'] ?? '',
        'capitulo' => $u['estado'] ?? '',
        'estado' => $u['estado'] ?? '',
      ];
      $existingM[] = $titleLower;
    }
  }
}

if ($q !== "") {
  $mangas = array_values(array_filter($mangas, function($m) use ($q) {
    return mb_stripos($m["titulo"], $q) !== false;
  }));
}
?>

<section class="hero">
  <div class="hero-inner">
    <div>
      <h1>Mangas</h1>
      <div class="quick">
        <a class="btn" href="index.php?page=inicio<?php echo $usuario?>">Volver</a>
        <a class="btn primary" href="index.php?page=areaPersonal<?php echo $usuario?>">Seguir series</a>
      </div>
    </div>
    <div class="badges">
      <div class="badge"><strong><?= count($mangas) ?></strong> resultados</div>
      <div class="badge"><strong>Modo</strong> oscuro</div>
      <div class="badge"><strong>Scroll</strong> continuo (mock)</div>
    </div>
  </div>
</section>

<section class="section">
  <div class="section-head">
    <div>
      <h2>Listado</h2>
      <p><?= $q !== "" ? "Filtrado por: " . htmlspecialchars($q) : "Todos los títulos" ?></p>
    </div>
  </div>

  <div class="grid">
    <?php if (count($mangas) === 0): ?>
      <div class="panel" style="grid-column: span 12;">
        No hay resultados para <strong><?= htmlspecialchars($q) ?></strong>.
      </div>
    <?php endif; ?>

    <?php foreach($mangas as $m): ?>
      <?php 
        $base = 'imagenes/mangas/' . preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($m['titulo']));
        $exts = ['jpg', 'jpeg', 'png', 'webp'];
        $imgPath = 'imagenes/logoAnimeXAI.JPG';
        foreach ($exts as $ext) {
          if (file_exists($base . '.' . $ext)) {
            $imgPath = $base . '.' . $ext;
            break;
          }
        }
      ?>
      <a class="card" href="index.php?page=manga&manga=<?= urlencode($m['titulo']) ?><?php echo $usuario?>">
        <div class="thumb" style="position:relative;">
          <img src="<?= $imgPath ?>" alt="Portada de <?= htmlspecialchars($m['titulo']) ?>" style="width:100%;height:120px;object-fit:cover;border-radius:8px 8px 0 0;">
          <span class="chip" style="position:absolute;top:8px;left:8px;">
            <?= htmlspecialchars($m["capitulo"]) ?>
          </span>
        </div>
        <div class="card-body">
          <h3 class="card-title"><?= htmlspecialchars($m["titulo"]) ?></h3>
          <div class="meta">
            <span><?= htmlspecialchars($m["tipo"]) ?></span>
            <span><?= htmlspecialchars($m["estado"]) ?></span>
            <span>Leer</span>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>