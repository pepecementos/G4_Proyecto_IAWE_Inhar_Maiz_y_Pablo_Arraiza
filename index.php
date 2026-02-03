<?php
    include "includes/funciones.php";
    include "includes/cabecera.php";


    // Si hace login, redirigir con el usuario en la URL
    if (isset($_POST["cuenta"])) {
        // Aquí podrías validar usuario/contraseña
        mostrar_mensaje('exito', '¡Bienvenido, ' . htmlspecialchars($_POST["username"]) . '!');
        redirigir("index.php?usuario=" . urlencode($_POST["username"]));
    }

    // Variable para saber si el usuario está logueado (solo por GET)
    $usuarioLogueado = usuario_autenticado();
    $nombreUsuario = $_GET["usuario"] ?? "";

    // Si no está logueado, mostrar el login
    if (!$usuarioLogueado) {
        include "vistas/login.php";
        exit();
    }

    //Barra de navegacion
    $pagina = $_GET["page"] ?? "inicio";
    
    if ($pagina == "inicio"){
        include "vistas/inicio.php";
    } elseif ($pagina == "animes"){
        include "vistas/animes.php";
    } elseif ($pagina == "mangas"){
        include "vistas/mangas.php";
    } elseif ($pagina == "tienda"){
        include "vistas/tienda.php";
    } elseif ($pagina == "areapersonal"){
        include "vistas/areaPersonal.php";
    } elseif ($pagina == "registro") {
        include "vistas/registro.php";
    } else {
        mostrar_error_404();
    }

    include "includes/pie.php";

?>