
    <h1>Crea tu cuenta: </h1>
            <form action='index.php' method='post'>
                <label for='usuario'>Nombre de usuario</label><br>
                    <input type='text' name='username' value=<?php if (isset($_POST["username"])) echo "username"?>><br>
                <label for='correo'>Correo electrónico</label> <br>
                    <input type='text' name='mail'><br>
                <label for='passwd'>Contraseña</label> <br>
                    <input type='password' name='passwd'><br>
                <label for='passwd2'>Confirmar contraseña</label> <br>
                    <input type='password' name='passwd2'><br>
                <button type='submit' name="crear">Crear cuenta</button>
            </form>

