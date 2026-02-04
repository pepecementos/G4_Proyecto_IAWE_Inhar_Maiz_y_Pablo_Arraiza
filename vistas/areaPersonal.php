<?php
// vistas/areaPersonal.php
require_once __DIR__ . '/../includes/funciones.php';

// Mostrar los datos del usuario real (si está autenticado)
if (usuario_autenticado()) {
    $u = obtener_usuario_por_nombre($_SESSION['usuario']);
    $usuario = [
      'nick' => $u['nombre_usuario'] ?? $_SESSION['usuario'],
      'plan' => 'Gratis',
      'favoritos' => ['Frieren', 'Steins;Gate', 'Berserk'],
      'siguiendo' => ['One Piece', 'Chainsaw Man']
    ];
} else {
    // Fallback (no debería llegarse aquí si la app verifica logueo)
    $usuario = [
      'nick' => 'Invitado',
      'plan' => 'Gratis',
      'favoritos' => ['Frieren', 'Steins;Gate', 'Berserk'],
      'siguiendo' => ['One Piece', 'Chainsaw Man']
    ];
}
?>

<section class="hero">
  <div class="hero-inner">
    <div>
      <h1>Área personal</h1>
      <!-- Texto de maqueta eliminado -->
      <div class="quick">
        <a class="btn" href="index.php?page=inicio">Inicio</a>
      </div>
    </div>
    <div class="badges">
      <div class="badge"><strong>Usuario:</strong> <?= htmlspecialchars($usuario["nick"]) ?></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="section-head">
    <div>
      <h2>Resumen</h2>
      <!-- Texto de componentes típico eliminado -->
    </div>
  </div>

  <?php
    // Cargar seguimientos reales del usuario
    $seguimientos = [];
    $animesSiguiendo = [];
    $mangasSiguiendo = [];
    if (usuario_autenticado()) {
        $uinfo = obtener_usuario_por_nombre($_SESSION['usuario']);
        if ($uinfo) {
            $seguimientos = obtener_seguimientos_por_usuario((int)$uinfo['id_usuario']);
            foreach ($seguimientos as $s) {
                if ($s['tipo'] === 'anime') $animesSiguiendo[] = $s;
                if ($s['tipo'] === 'manga') $mangasSiguiendo[] = $s;
            }
        }
    }
    $urlUsuarioParam = usuario_autenticado() ? "&usuario=" . urlencode($_SESSION['usuario']) : '';
    ?>

  <div class="grid">
    <div class="panel" style="grid-column: span 6;">
      <h3 style="margin:0 0 10px;">⭐ Animes que sigues</h3>
      <?php if (count($animesSiguiendo) === 0): ?>
        <div style="color:var(--muted);font-size:13px;margin-bottom:10px;">No sigues ningún anime.</div>
      <?php else: ?>
          <div class="grid">
            <?php foreach($animesSiguiendo as $a): ?>
              <?php 
                $info = obtener_info_titulo($a['titulo']);
                $base = 'imagenes/animes/' . preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($a['titulo']));
                $exts = ['jpg', 'jpeg', 'png', 'webp'];
                              $exts = ['jpg', 'jpeg', 'png', 'webp'];
                $imgPath = 'imagenes/logoAnimeXAI.JPG';
                foreach ($exts as $ext) {
                  if (file_exists($base . '.' . $ext)) {
                    $imgPath = $base . '.' . $ext;
                    break;
                  }
                }
              ?>
              <div class="card" style="display:flex;align-items:center;padding:10px;gap:12px;margin-bottom:10px;">
                <div class="thumb" style="width:70px;height:70px;min-width:70px;min-height:70px;position:relative;overflow:hidden;border-radius:6px;">
                  <img src="<?= $imgPath ?>" alt="Portada de <?= htmlspecialchars($a['titulo']) ?>" style="width:100%;height:100%;object-fit:cover;display:block;">
                  <span class="chip" style="position:absolute;top:6px;left:6px;z-index:2;"><?= htmlspecialchars($info['estado'] ?? '') ?></span>
                </div>
                <div style="flex:1;">
                  <h3 class="card-title" style="margin:0 0 6px;"><a href="index.php?page=anime&anime=<?= urlencode($a['titulo']) ?><?= $urlUsuarioParam ?>"><?= htmlspecialchars($a['titulo']) ?></a></h3>
                  <div class="meta" style="font-size:13px;color:var(--muted);">
                    <span><?= htmlspecialchars($info['tag1'] ?? '') ?></span>
                    <span><?= htmlspecialchars($info['tag2'] ?? '') ?></span>
                  </div>
                </div>
              </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="panel" style="grid-column: span 6;">
      <h3 style="margin:0 0 10px;">📚 Mangas que sigues</h3>
      <?php if (count($mangasSiguiendo) === 0): ?>
        <div style="color:var(--muted);font-size:13px;margin-bottom:10px;">No sigues ningún manga.</div>
      <?php else: ?>
        <div class="grid">
          <?php foreach($mangasSiguiendo as $m): ?>
            <?php 
              $base = 'imagenes/mangas/' . preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($m['titulo']));
              $exts = ['jpg', 'png', 'webp'];
              $imgPath = 'imagenes/logoAnimeXAI.JPG';
              foreach ($exts as $ext) {
                if (file_exists($base . '.' . $ext)) {
                  $imgPath = $base . '.' . $ext;
                  break;
                }
              }
            ?>
            <div class="card" style="display:flex;align-items:center;padding:10px;gap:12px;margin-bottom:10px;">
              <div class="thumb" style="width:70px;height:70px;min-width:70px;min-height:70px;position:relative;overflow:hidden;border-radius:6px;">
                <img src="<?= $imgPath ?>" alt="Portada de <?= htmlspecialchars($m['titulo']) ?>" style="width:100%;height:100%;object-fit:cover;display:block;">
              </div>
              <div style="flex:1;">
                <h3 class="card-title" style="margin:0 0 6px;"><a href="index.php?page=manga&manga=<?= urlencode($m['titulo']) ?><?= $urlUsuarioParam ?>"><?= htmlspecialchars($m['titulo']) ?></a></h3>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Panel vacío eliminado para evitar barra blanca -->
</section>