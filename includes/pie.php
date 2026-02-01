<?php
// includes/pie.php
$anio = date("Y");
?>
  </div>
</main>

<footer class="footer">
  <div class="container footer-inner">
    <div>
      <strong>AniManga</strong> · <span>© <?= $anio ?></span>
      <div style="font-size:12px;margin-top:4px;">
        Demo educativa. Añade BD/API y autenticación cuando lo necesites.
      </div>
    </div>

    <div style="display:flex;gap:12px;flex-wrap:wrap;">
      <a href="index.php?page=inicio">Inicio</a>
      <a href="index.php?page=animes">Animes</a>
      <a href="index.php?page=mangas">Mangas</a>
      <a href="index.php?page=tienda">Tienda</a>
    </div>
  </div>
</footer>

</body>
</html>
