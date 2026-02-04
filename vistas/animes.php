
<?php
// vistas/animes.php
require_once __DIR__ . '/../includes/funciones.php';

$q = trim($_GET["q"] ?? "");

$animes = [
  ["titulo"=>"Attack on Titan", "anio"=>2013, "genero"=>"Acción", "estado"=>"Finalizado", "rating"=>"9.0", "img"=>"https://cdn.myanimelist.net/images/anime/10/47347.jpg"],
  ["titulo"=>"Demon Slayer", "anio"=>2019, "genero"=>"Acción", "estado"=>"En emisión", "rating"=>"8.7", "img"=>"https://cdn.myanimelist.net/images/anime/1915/110511.jpg"],
  ["titulo"=>"Spy x Family", "anio"=>2022, "genero"=>"Comedia", "estado"=>"En emisión", "rating"=>"8.5", "img"=>"https://cdn.myanimelist.net/images/anime/1764/122794.jpg"],
  ["titulo"=>"Fullmetal Alchemist: Brotherhood", "anio"=>2009, "genero"=>"Aventura", "estado"=>"Finalizado", "rating"=>"9.1", "img"=>"https://cdn.myanimelist.net/images/anime/1223/96541.jpg"],
  ["titulo"=>"My Hero Academia", "anio"=>2016, "genero"=>"Shonen", "estado"=>"En emisión", "rating"=>"8.2", "img"=>"https://cdn.myanimelist.net/images/anime/10/78745.jpg"],
  ["titulo"=>"Steins;Gate", "anio"=>2011, "genero"=>"Sci-Fi", "estado"=>"Finalizado", "rating"=>"9.0", "img"=>"https://cdn.myanimelist.net/images/anime/5/73199.jpg"],
];

// Añadir los trending que sean tipo "Anime" (sin duplicados)
$trending = obtener_trending();
$existing = array_map(function($a){ return mb_strtolower($a['titulo']); }, $animes);
foreach ($trending as $t) {
  if ((($t['tipo'] ?? '') === 'Anime')) {
    $titleLower = mb_strtolower($t['titulo']);
    if (!in_array($titleLower, $existing)) {
      $animes[] = [
        'titulo' => $t['titulo'],
        'anio' => '',
        'genero' => $t['tag1'] ?? '',
        'estado' => $t['estado'] ?? '',
        'rating' => '-',
      ];
      $existing[] = $titleLower;
    }
  }
}

if ($q !== "") {
  $animes = array_values(array_filter($animes, function($a) use ($q) {
    return mb_stripos($a["titulo"], $q) !== false;
  }));
}
?>

<section class="hero">
  <div class="hero-inner">
    <div>
      <h1>Animes</h1>
      <div class="quick">
        <a class="btn" href="index.php?page=inicio<?php echo $usuario?>">Volver</a>
        <a class="btn primary" href="index.php?page=areaPersonal<?php echo $usuario?>">Guardar favoritos</a>
      </div>
    </div>
    <div class="badges">
      <div class="badge"><strong><?= count($animes) ?></strong> resultados</div>
      <div class="badge"><strong>HD</strong> streaming (mock)</div>
      <div class="badge"><strong>Sub</strong> / Doblaje (mock)</div>
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
    <?php if (count($animes) === 0): ?>
      <div class="panel" style="grid-column: span 12;">
        No hay resultados para <strong><?= htmlspecialchars($q) ?></strong>.
      </div>
    <?php endif; ?>

    <?php foreach($animes as $a): ?>
      <?php
        $base = 'imagenes/animes/' . preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($a['titulo']));
        $exts = ['jpg', 'jpeg', 'png', 'webp'];
        $imgPath = 'imagenes/logoAnimeXAI.JPG';
        foreach ($exts as $ext) {
          if (file_exists($base . '.' . $ext)) {
            $imgPath = $base . '.' . $ext;
            break;
          }
        }
      ?>
      <a class="card" href="index.php?page=anime&anime=<?= urlencode($a['titulo']) ?><?php echo $usuario?>">
        <div class="thumb" style="position:relative;">
          <img src="<?= $imgPath ?>" alt="Portada de <?= htmlspecialchars($a['titulo']) ?>" style="width:100%;height:120px;object-fit:cover;border-radius:8px 8px 0 0;">
          <span class="chip" style="position:absolute;top:8px;left:8px;">
            <?= htmlspecialchars($a["estado"]) ?> · <?= htmlspecialchars((string)$a["anio"]) ?>
          </span>
        </div>
        <div class="card-body">
          <h3 class="card-title"><?= htmlspecialchars($a["titulo"]) ?></h3>
          <div class="meta">
            <span><?= htmlspecialchars($a["genero"]) ?></span>
            <span>⭐ <?= htmlspecialchars($a["rating"]) ?></span>
            <span>Ver</span>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>