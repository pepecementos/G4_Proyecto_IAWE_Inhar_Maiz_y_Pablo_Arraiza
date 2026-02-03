<?php
// vistas/error404.php
// Vista para errores 404. Se muestra cuando no existe la página solicitada.

if (!isset($errorMessage)) {
    $errorMessage = 'No hemos podido encontrar la página que buscas. Comprueba la URL o vuelve al inicio.';
}
http_response_code(404);
?>

<section class="section">
  <div class="section-head">
    <div>
      <h1>404 — Página no encontrada</h1>
      <p><?php echo htmlspecialchars($errorMessage); ?></p>
    </div>
  </div>

  <div style="text-align:center; margin-top: 20px;">
    <a class="btn" href="index.php">Volver al inicio</a>
  </div>
</section>
