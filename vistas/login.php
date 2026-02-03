    <form action='index.php' method='post'>
        <label for='usuario'>Usuario</label>
        <input type='text' name='username' required>
        <label for='passwd'>Contraseña</label>    
        <input type='password' name='passwd' required>
        <input type='submit' name="cuenta" value="Entrar">
        <p>¿No tienes cuenta? ¡Crea una <a href='vistas/registro.php'>aquí!<a></p>
    </form>

    <?php
    require_once __DIR__ . '/../includes/funciones.php';
    if (isset($_GET['error'])) {
        mostrar_mensaje('error', 'Usuario o contraseña incorrectos.');
    }
    ?>
