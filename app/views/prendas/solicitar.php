<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4 mb-4 text-center">
    <?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4 mb-4">
    <h1 class="text-primary text-center">Solicitar venta de prenda</h1>

    <form method="POST" action="solicitar" class="mt-4">

        <div class="mb-3">
            <label class="form-label">Tipo prenda</label>
            <input type="number" name="tipoPrenda" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Colegio</label>
            <input type="number" name="colegio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado prenda</label>
            <input type="number" name="estadoPrenda" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Enviar solicitud</button>

    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>