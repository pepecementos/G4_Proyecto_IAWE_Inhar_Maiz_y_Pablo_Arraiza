<?php
// vistas/areaPersonal.php
require_once __DIR__ . '/../includes/funciones.php';

// Demo: simulación de "usuario"
$usuario = [
  "nick" => "Invitado",
  "plan" => "Gratis",
  "favoritos" => ["Frieren", "Steins;Gate", "Berserk"],
  "siguiendo" => ["One Piece", "Chainsaw Man"]
];
?>

<section class="hero">
  <div class="hero-inner">
    <div>
      <h1>Área personal</h1>
      <p>
        Aquí irán login/registro, favoritos, historial y notificaciones.
        Por ahora, es una maqueta visual.
      </p>
      <div class="quick">
        <button class="btn primary" type="button" onclick="alert('Demo: aquí iría el login/registro')">Iniciar sesión</button>
        <a class="btn" href="index.php?page=inicio<?php echo $usuario?>">Inicio</a>
      </div>
    </div>
    <div class="badges">
      <div class="badge"><strong>Usuario:</strong> <?= htmlspecialchars($usuario["nick"]) ?></div>
      <div class="badge"><strong>Plan:</strong> <?= htmlspecialchars($usuario["plan"]) ?></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="section-head">
    <div>
      <h2>Resumen</h2>
      <p>Componentes típicos de un portal</p>
    </div>
  </div>

  <div class="grid">
    <div class="panel" style="grid-column: span 6;">
      <h3 style="margin:0 0 10px;">⭐ Favoritos</h3>
      <div style="color:var(--muted);font-size:13px;margin-bottom:10px;">Lista demo</div>
      <div class="meta">
        <?php foreach($usuario["favoritos"] as $f): ?>
          <span><?= htmlspecialchars($f) ?></span>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="panel" style="grid-column: span 6;">
      <h3 style="margin:0 0 10px;">📌 Siguiendo</h3>
      <div style="color:var(--muted);font-size:13px;margin-bottom:10px;">Para avisos de nuevos capítulos</div>
      <div class="meta">
        <?php foreach($usuario["siguiendo"] as $s): ?>
          <span><?= htmlspecialchars($s) ?></span>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="panel" style="grid-column: span 12;">
      <h3 style="margin:0 0 10px;">Siguientes mejoras recomendadas</h3>
      <ul style="margin:0;color:var(--muted);line-height:1.7;">
        <li>Login/registro con <strong>password_hash</strong> y sesiones.</li>
        <li>Tabla en BD: usuarios, favoritos, historial, animes, mangas, capítulos.</li>
        <li>Páginas de detalle: <code>anime.php?id=</code> / <code>manga.php?id=</code>.</li>
        <li>Buscador real con consulta SQL (LIKE / FULLTEXT).</li>
      </ul>
    </div>
  </div>
</section>