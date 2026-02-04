<?php
// includes/cabecera.php
// Variables opcionales:
// $tituloPagina (string)  -> título <title>
// $paginaActiva (string)  -> inicio|animes|mangas|tienda|areaPersonal
$tituloPagina = $tituloPagina ?? "AnimeXAI";
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
      <img class="brand-logo" src="imagenes/logoAnimeXAI.JPG" alt="Logo AnimeXAI" width="38" height="38">
      <div class="brand-text">
        <span class="brand-title">AnimeXAI</span>
        <small>Tu portal de Anime y Manga</small>
      </div>
    </a>

    <nav class="nav" aria-label="Navegación principal">
        <?php 
            // En lugar de depender de GET, usamos la sesión para el usuario autenticado
            $usuario = usuario_autenticado() ? "&usuario=" . urlencode($_SESSION['usuario']) : "";
        ?>
      <a class="<?= navClass("inicio", $paginaActiva) ?>" href="index.php?page=inicio<?php echo $usuario; ?>">Inicio</a>
      <a class="<?= navClass("animes", $paginaActiva) ?>" href="index.php?page=animes<?php echo $usuario; ?>">Animes</a>
      <a class="<?= navClass("mangas", $paginaActiva) ?>" href="index.php?page=mangas<?php echo $usuario; ?>">Mangas</a>
      <a class="<?= navClass("tienda", $paginaActiva) ?>" href="index.php?page=tienda<?php echo $usuario; ?>">Tienda</a>
      <a class="<?= navClass("areaPersonal", $paginaActiva) ?>" href="index.php?page=areaPersonal<?php echo $usuario; ?>">Área personal</a>
          <?php if (usuario_autenticado()): ?>
                <a class="logout" href="index.php?logout=1">Cerrar sesión</a>
              <?php endif; ?>
    </nav>


    <div class="actions">

      <a class="btn primary" href="index.php?page=areaPersonal">
        Cuenta
      </a>
    </div>
  </div>
</header>

<?php if (function_exists('mostrar_flash')): ?>
  <div class="container">
    <?php mostrar_flash(); ?>
  </div>
<?php endif; ?>

<main id="contenido" class="main">
  <div class="container">