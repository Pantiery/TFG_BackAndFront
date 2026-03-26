<?php require_once __DIR__ . '/../layout/header.php'; ?>

<?php if (isset($_SESSION['error-registro'])): ?>
    <p style="color:red;">
        <?= $_SESSION['error'] ?>
    </p>
    <?php unset($_SESSION['error-registro']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error-campos'])): ?>
    <p style="color:red;">
        <?= $_SESSION['error-campos'] ?>
    </p>
    <?php unset($_SESSION['error-campos']); ?>
<?php endif; ?>

<form method="POST" action="/proyecto_TFG/TFG_BackAndFront/public/register" class="grid-layout">

    <h2>Regístrate</h2>

    <label>Nombre</label>
    <input type="text" name="nombre" class="form-control" maxlength="25">

    <label>Primer apellido</label>
    <input type="text" name="apellido1" class="form-control" maxlength="25" required>

    <label>Segundo apellido (opcional)</label>
    <input type="text" name="apellido2" class="form-control" maxlength="25">

    <label>E-mail</label>
    <input type="email" name="email" class="form-control" maxlength="100" required>

    <label>Contraseña</label>
    <input type="password" name="password" class="form-control" minlength="8"
        pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$" required>

    <button type="submit" class="btn btn-primary">Registrarme</button>

</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>