<?php
    //LOGIN
    //Procede aqui:

    //REGISTRO
    //Procede aqui:

    //Barra de navegacion
    if ($_GET["pagina"] == "inicio"){
        include "inicio.php";
    } elseif ($_GET["pagina"] == "animes"){
        include "animes.php";
    } elseif ($_GET["pagina"] == "mangas"){
        include "mangas.php";
    } elseif ($_GET["pagina"] == "tienda"){
        include "tienda.php";
    } elseif ($_GET["pagina"] == "areapersonal"){
        include "areapersonal.php";
    }
?>