
<?php require_once __DIR__ . '/../includes/funciones.php'; mostrar_flash(); $errors = get_form_errors(); ?>

    <h1>Crea tu cuenta: </h1>
    <?php if (isset($errors['general'])): ?><div class="field-error"><?= htmlspecialchars($errors['general']) ?></div><?php endif; ?>
    <form action='index.php?page=registro' method='post' novalidate>
        <label for='usuario'>Nombre de usuario</label><br>
        <input type='text' name='username' value="<?= old('username') ?>" required>
        <?php if (isset($errors['username'])): ?><div class="field-error"><?= htmlspecialchars($errors['username']) ?></div><?php endif; ?>
        
        <label for='correo'>Correo electrónico</label><br>
        <input type='email' name='mail' value="<?= old('mail') ?>" required>
        <?php if (isset($errors['mail'])): ?><div class="field-error"><?= htmlspecialchars($errors['mail']) ?></div><?php endif; ?>
        
        <label for='passwd'>Contraseña</label><br>
        <input type='password' name='passwd' required>
        <?php if (isset($errors['passwd'])): ?><div class="field-error"><?= htmlspecialchars($errors['passwd']) ?></div><?php endif; ?>
        
        <label for='passwd2'>Confirmar contraseña</label><br>
        <input type='password' name='passwd2' required>
        <?php if (isset($errors['passwd2'])): ?><div class="field-error"><?= htmlspecialchars($errors['passwd2']) ?></div><?php endif; ?>
        
        <button type='submit' name="crear">Crear cuenta</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a></p>
