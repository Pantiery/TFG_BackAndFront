<?php require_once __DIR__ . '/../layout/header.php'; ?>

    <form method="POST" class="grid-layout">
            
        <h2>Regístrate</h2>

        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>

        <label>Primer apellido</label>
        <input type="text" name="primer_apellido" class="form-control" required>

        <label>Segundo apellido (opcional)</label>
        <input type="text" name="segundo_apellido" class="form-control">

        <label>E-mail</label>
        <input type="email" name="email" class="form-control" required>

        <label>Contraseña</label>
        <input type="password" name="contra" class="form-control" required>

        <button type="submit" class="btn btn-primary">Registrarme</button>

    </form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>