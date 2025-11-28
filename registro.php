<?php

    include "/includes/cabecera.php";

?>
    <h1>Crea tu cuenta: </h1>
            <form action='index.php' method='post'>
                <label for='usuario'>Nombre de usuario</label><br>
                    <input type='text' name='username'><br>
                <label for='correo'>Correo electrónico</label> <br>
                    <input type='text' name='mail'><br>
                <label for='passwd'>Contraseña</label> <br>
                    <input type='password' name='passwd'><br>
                <label for='passwd2'>Confirmar contraseña</label> <br>
                    <input type='password' name='passwd2'><br>
                <input type='submit' value='Crear cuenta'>
            </form>

<?php            
    include "/includes/pie.php";
?>
