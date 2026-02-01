<?php
// index.php (raíz)

// Página solicitada
$page = $_GET["page"] ?? "inicio";

// Lista blanca de vistas
$map = [
  "inicio" => "vistas/inicio.php",
  "animes" => "vistas/animes.php",
  "mangas" => "vistas/mangas.php",
  "tienda" => "vistas/tienda.php",
  "areaPersonal" => "vistas/areaPersonal.php",
];

// Fallback si no existe
if (!array_key_exists($page, $map)) {
  $page = "inicio";
}

// Variables para cabecera
$tituloPagina = match($page) {
  "inicio" => "AniManga · Inicio",
  "animes" => "AniManga · Animes",
  "mangas" => "AniManga · Mangas",
  "tienda" => "AniManga · Tienda",
  "areaPersonal" => "AniManga · Área personal",
  default => "AniManga",
};

$paginaActiva = $page;

require __DIR__ . "/includes/cabecera.php";
require __DIR__ . "/" . $map[$page];
require __DIR__ . "/includes/pie.php";