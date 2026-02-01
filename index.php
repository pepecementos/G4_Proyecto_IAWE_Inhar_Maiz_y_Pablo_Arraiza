<?php
    include "includes/cabecera.php";
    
    // Si hace login, redirigir con el usuario en la URL
    if (isset($_POST["cuenta"])) {
        header("Location: index.php?usuario=" . urlencode($_POST["username"]));
        exit();
    }
    
    // Variable para saber si el usuario está logueado (mirar GET)
    $usuarioLogueado = isset($_GET["usuario"]) ? true : false;
    $nombreUsuario = $_GET["usuario"] ?? "";
    
    // Si no está logueado, mostrar el login
    if (!$usuarioLogueado) {
        include "vistas/login.php";
    }
    
    //Barra de navegacion
    $pagina = $_GET["pagina"] ?? "inicio";
    
    if ($pagina == "inicio"){
        include "vistas/inicio.php";
    } elseif ($pagina == "animes"){
        include "vistas/animes.php";
    } elseif ($pagina == "mangas"){
        include "vistas/mangas.php";
    } elseif ($pagina == "tienda"){
        include "vistas/tienda.php";
    } elseif ($pagina == "areapersonal"){
        include "vistas/areapersonal.php";
    }

    include "includes/pie.php";

?>