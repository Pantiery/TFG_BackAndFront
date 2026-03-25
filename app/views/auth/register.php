<?php require_once __DIR__ . '/../layout/header.php'; ?>

    <form method="POST" action="/proyecto_TFG/TFG_BackAndFront/public/register" class="grid-layout">
            
        <h2>Regístrate</h2>

        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>

        <label>Primer apellido</label>
        <input type="text" name="apellido1" class="form-control" required>

        <label>Segundo apellido (opcional)</label>
        <input type="text" name="apellido2" class="form-control">

        <label>E-mail</label>
        <input type="email" name="email" class="form-control" required>

        <label>Contraseña</label>
        <input type="password" name="password" class="form-control" required>

        <button type="submit" class="btn btn-primary">Registrarme</button>

    </form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>