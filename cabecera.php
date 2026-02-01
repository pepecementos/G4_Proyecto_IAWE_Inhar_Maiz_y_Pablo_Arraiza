<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <link rel="stylesheet" type="text/css" href="css/estilo.css" />
        <title>Bucles</title>
    </head>
    <body>
        <div id="contenido">
        <div id="cabecera">
            <h2>AnimeXAI</h2>
            <nav id="menuNavegación">
                <?php 
                    $usuario = isset($_GET["usuario"]) ? "&usuario=" . urlencode($_GET["usuario"]) : "";
                ?>
                <a href="index.php?pagina=inicio<?php echo $usuario; ?>">INICIO</a>
                <a href="index.php?pagina=animes<?php echo $usuario; ?>">ANIMES</a>
                <a href="index.php?pagina=mangas<?php echo $usuario; ?>">MANGAS</a>
                <a href="index.php?pagina=tienda<?php echo $usuario; ?>">TIENDA</a>
                <a href="index.php?pagina=areapersonal<?php echo $usuario; ?>">AREA PERSONAL</a>
                <?php if (isset($_GET["usuario"])): ?>
                    <span style="margin-left: 20px;">Hola, <?php echo htmlspecialchars($_GET["usuario"]); ?></span>
                    <a href="index.php" style="color: red; margin-left: 10px;">Cerrar sesión</a>
                <?php endif; ?>
            </nav>
        </div>
        <div id="principal">
