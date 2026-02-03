<?php
// includes/cabecera.php
// Variables opcionales:
// $tituloPagina (string)  -> título <title>
// $paginaActiva (string)  -> inicio|animes|mangas|tienda|areaPersonal
$tituloPagina = $tituloPagina ?? "AniManga";
$paginaActiva = $paginaActiva ?? "inicio";
require_once __DIR__ . '/funciones.php';

function navClass(string $key, string $active): string {
  return $key === $active ? "active" : "";
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($tituloPagina) ?></title>
  <link rel="stylesheet" href="/G4_Proyecto_IAWE_Inhar_Maiz_y_Pablo_Arraiza/css/style.css">
</head>
<body>
<a class="skip" href="#contenido">Saltar al contenido</a>

<header class="header">
  <div class="container header-inner">
    <a class="brand" href="index.php?page=inicio" aria-label="Inicio">
      <span class="logo" aria-hidden="true"></span>
      <div>
        AniManga
        <small>Anime + Manga en un solo lugar</small>
      </div>
    </a>

    <nav class="nav" aria-label="Navegación principal">
        <?php 
            $usuario = usuario_autenticado() ? "&usuario=" . urlencode($_GET["usuario"]) : "";
        ?>
      <a class="<?= navClass("inicio", $paginaActiva) ?>" href="index.php?page=inicio<?php echo $usuario; ?>">Inicio</a>
      <a class="<?= navClass("animes", $paginaActiva) ?>" href="index.php?page=animes<?php echo $usuario; ?>">Animes</a>
      <a class="<?= navClass("mangas", $paginaActiva) ?>" href="index.php?page=mangas<?php echo $usuario; ?>">Mangas</a>
      <a class="<?= navClass("tienda", $paginaActiva) ?>" href="index.php?page=tienda<?php echo $usuario; ?>">Tienda</a>
      <a class="<?= navClass("areaPersonal", $paginaActiva) ?>" href="index.php?page=areaPersonal<?php echo $usuario; ?>">Área personal</a>
          <?php if (isset($_GET["usuario"])): ?>
                <span style="margin-left: 20px;">Hola, <?php echo htmlspecialchars($_GET["usuario"]); ?></span>
                <a href="index.php" style="color: red; margin-left: 10px;">Cerrar sesión</a>
              <?php endif; ?>
    </nav>


    <div class="actions">
      <form class="search" action="index.php" method="get" role="search">
        <input type="hidden" name="page" value="<?= htmlspecialchars($paginaActiva) ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <input name="q" placeholder="Buscar (demo)..." autocomplete="off">
      </form>

      <a class="btn primary" href="index.php?page=areaPersonal">
        Cuenta
      </a>
    </div>
  </div>
</header>

<main id="contenido" class="main">
  <div class="container">