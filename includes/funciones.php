<?php

// 1. Función para mostrar mensajes flash (notificaciones temporales)
function mostrar_mensaje($tipo, $mensaje) {
    echo "<div class='mensaje mensaje-$tipo'>$mensaje</div>";
}

// 2. Función para redirigir a otra página
function redirigir($url) {
    header("Location: $url");
    exit();
}

// 3. Función para comprobar si el usuario está autenticado (por GET o POST)
function usuario_autenticado() {
    return isset($_GET['usuario']) && $_GET['usuario'] !== '';
}  
