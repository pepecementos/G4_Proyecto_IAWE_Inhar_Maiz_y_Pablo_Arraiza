<?php
    include "includes/cabecera.php";
    //LOGIN
    //Procede aqui:

    //REGISTRO
    //Procede aqui:
    if ($_POST )
    //Barra de navegacion
    if ($_GET["pagina"] == "inicio" or empty("pagina")){
        include "vistas/inicio.php";
    } elseif ($_GET["pagina"] == "animes"){
        include "vistas/animes.php";
    } elseif ($_GET["pagina"] == "mangas"){
        include "vistas/mangas.php";
    } elseif ($_GET["pagina"] == "tienda"){
        include "vistas/tienda.php";
    } elseif ($_GET["pagina"] == "areapersonal"){
        include "vistas/areapersonal.php";
    }

    include "includes/pie.php";

?>