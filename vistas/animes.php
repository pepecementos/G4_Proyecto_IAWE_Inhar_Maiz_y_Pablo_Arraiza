<?php
// vistas/animes.php

$q = trim($_GET["q"] ?? "");

$animes = [
  ["titulo"=>"Attack on Titan", "anio"=>2013, "genero"=>"Acción", "estado"=>"Finalizado", "rating"=>"9.0"],
  ["titulo"=>"Demon Slayer", "anio"=>2019, "genero"=>"Acción", "estado"=>"En emisión", "rating"=>"8.7"],
  ["titulo"=>"Spy x Family", "anio"=>2022, "genero"=>"Comedia", "estado"=>"En emisión", "rating"=>"8.5"],
  ["titulo"=>"Fullmetal Alchemist: Brotherhood", "anio"=>2009, "genero"=>"Aventura", "estado"=>"Finalizado", "rating"=>"9.1"],
  ["titulo"=>"My Hero Academia", "anio"=>2016, "genero"=>"Shonen", "estado"=>"En emisión", "rating"=>"8.2"],
  ["titulo"=>"Steins;Gate", "anio"=>2011, "genero"=>"Sci-Fi", "estado"=>"Finalizado", "rating"=>"9.0"],
];

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
      <p>Catálogo de ejemplo. Usa el buscador de arriba (campo “Buscar (demo)…”).</p>
      <div class="quick">
        <a class="btn" href="index.php?page=inicio">Volver</a>
        <a class="btn primary" href="index.php?page=areaPersonal">Guardar favoritos (demo)</a>
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
      <p><?= $q !== "" ? "Filtrado por: " . htmlspecialchars($q) : "Todos los títulos (demo)" ?></p>
    </div>
  </div>

  <div class="grid">
    <?php if (count($animes) === 0): ?>
      <div class="panel" style="grid-column: span 12;">
        No hay resultados para <strong><?= htmlspecialchars($q) ?></strong>.
      </div>
    <?php endif; ?>

    <?php foreach($animes as $a): ?>
      <a class="card" href="index.php?page=animes">
        <div class="thumb">
          <span class="chip"><?= htmlspecialchars($a["estado"]) ?> · <?= htmlspecialchars((string)$a["anio"]) ?></span>
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