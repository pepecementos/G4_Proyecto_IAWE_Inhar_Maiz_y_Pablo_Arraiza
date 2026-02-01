<?php
// vistas/mangas.php

$q = trim($_GET["q"] ?? "");

$mangas = [
  ["titulo"=>"Berserk", "tipo"=>"Seinen", "capitulo"=>"Cap. 375", "estado"=>"En publicación"],
  ["titulo"=>"One Punch Man", "tipo"=>"Shonen", "capitulo"=>"Cap. 203", "estado"=>"En publicación"],
  ["titulo"=>"Vinland Saga", "tipo"=>"Seinen", "capitulo"=>"Cap. 216", "estado"=>"En publicación"],
  ["titulo"=>"Haikyuu!!", "tipo"=>"Deporte", "capitulo"=>"Completo", "estado"=>"Finalizado"],
  ["titulo"=>"Death Note", "tipo"=>"Thriller", "capitulo"=>"Completo", "estado"=>"Finalizado"],
  ["titulo"=>"Tokyo Revengers", "tipo"=>"Acción", "capitulo"=>"Completo", "estado"=>"Finalizado"],
];

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
      <p>Lectura tipo catálogo. Luego puedes añadir páginas de detalle y lector por capítulos.</p>
      <div class="quick">
        <a class="btn" href="index.php?page=inicio">Volver</a>
        <a class="btn primary" href="index.php?page=areaPersonal">Seguir series (demo)</a>
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
      <p><?= $q !== "" ? "Filtrado por: " . htmlspecialchars($q) : "Todos los títulos (demo)" ?></p>
    </div>
  </div>

  <div class="grid">
    <?php if (count($mangas) === 0): ?>
      <div class="panel" style="grid-column: span 12;">
        No hay resultados para <strong><?= htmlspecialchars($q) ?></strong>.
      </div>
    <?php endif; ?>

    <?php foreach($mangas as $m): ?>
      <a class="card" href="index.php?page=mangas">
        <div class="thumb">
          <span class="chip"><?= htmlspecialchars($m["capitulo"]) ?></span>
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