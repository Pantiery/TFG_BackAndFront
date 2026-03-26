<?php require_once __DIR__ . '/../layout/header.php'; ?>

    <form method="POST" action="/proyecto_TFG/TFG_BackAndFront/public/register" class="grid-layout" onsubmit="return validarForm()" novalidate>
            
        <h2>Regístrate</h2>
        <div id="div"></div>
        <label>Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
        <div id="div1"></div>
        <label>Primer apellido</label>
        <input type="text" name="apellido1" id="apellido1" class="form-control" required>
        <div id="div2"></div>
        <label>Segundo apellido (opcional)</label>
        <input type="text" name="apellido2" id="apellido2" class="form-control">
        <div id="div3"></div>
        <label>E-mail</label>
        <input type="email" name="email" id="email" class="form-control" required>
        <div id="div4"></div>
        <label>Contraseña</label>
        <input type="password" name="password" id="password" class="form-control" required>
        <div id="div5"></div>
        <button type="submit" class="btn btn-primary">Registrarme</button>

    </form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>