<?php

    include "/includes/cabeceraproy.php";
    
?>

    <h1>¡Bienvenido a AnimeXAI!</h1>
            <form action='index.php' method='post'>
                <label for='usuario'>Usuario</label>
                <input type='text' name='username'>
                <label for='passwd'>Contraseña</label>    
                <input type='password' name='passwd'>
                <input type='submit'>
                <p>¿No tienes cuenta? ¡Crea una <a href='registro.php'>aquí!<a></p>
                <br><a href='contra.php'>He olvidado mi contraseña<a>
            </form>
<?php

    include "/includes/pieproy.php";

?>