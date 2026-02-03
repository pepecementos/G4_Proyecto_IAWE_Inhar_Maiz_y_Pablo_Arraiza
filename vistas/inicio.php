
<?php
// vistas/inicio.php
require_once __DIR__ . '/../includes/funciones.php';

$trending = [
  ["titulo"=>"Jujutsu Kaisen", "tipo"=>"Anime", "estado"=>"En emisión", "tag1"=>"Acción", "tag2"=>"Shonen"],
  ["titulo"=>"Frieren", "tipo"=>"Anime", "estado"=>"Finalizado", "tag1"=>"Fantasía", "tag2"=>"Aventura"],
  ["titulo"=>"Solo Leveling", "tipo"=>"Anime", "estado"=>"Temporada 2", "tag1"=>"Acción", "tag2"=>"RPG"],
  ["titulo"=>"One Piece", "tipo"=>"Anime", "estado"=>"En emisión", "tag1"=>"Aventura", "tag2"=>"Largo"],
];

$ultimosMangas = [
  ["titulo"=>"Chainsaw Man", "tipo"=>"Manga", "estado"=>"Cap. 154", "tag1"=>"Oscuro", "tag2"=>"Acción"],
  ["titulo"=>"Blue Lock", "tipo"=>"Manga", "estado"=>"Cap. 289", "tag1"=>"Deporte", "tag2"=>"Rivalidad"],
  ["titulo"=>"Oshi no Ko", "tipo"=>"Manga", "estado"=>"Cap. 141", "tag1"=>"Drama", "tag2"=>"Industria"],
  ["titulo"=>"Kaiju No. 8", "tipo"=>"Manga", "estado"=>"Cap. 118", "tag1"=>"Monstruos", "tag2"=>"Acción"],
];
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
      <a class="card" href="index.php?page=animes<?php echo $usuario?>">
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
      <a class="card" href="index.php?page=mangas<?php echo $usuario?>">
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