    <?php require_once __DIR__ . '/../includes/funciones.php'; mostrar_flash(); $errors = get_form_errors(); ?>
    <form action='index.php' method='post' novalidate>
        <label for='usuario'>Usuario</label>
        <input type='text' name='username' value="<?= old('username') ?>" required>
        <?php if (isset($errors['username'])): ?><div class="field-error"><?= htmlspecialchars($errors['username']) ?></div><?php endif; ?>

        <label for='passwd'>Contraseña</label>    
        <input type='password' name='passwd' required>
        <?php if (isset($errors['passwd'])): ?><div class="field-error"><?= htmlspecialchars($errors['passwd']) ?></div><?php endif; ?>

        <input type='submit' name="cuenta" value="Entrar">
        <p>¿No tienes cuenta? ¡Crea una <a href='index.php?page=registro'>aquí</a>!</p>
    </form>
