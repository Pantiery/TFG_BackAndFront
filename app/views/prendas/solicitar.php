<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4 mb-4">

    <h2 class="text-center mb-4">Solicitar venta de prenda</h2>

    <!-- MENSAJE DE ÉXITO -->
    <?php if (isset($_SESSION['success_prenda'])): ?>
        <div class="alert alert-success text-center">
            <?= $_SESSION['success_prenda'] ?>
        </div>
        <?php unset($_SESSION['success_prenda']); ?>
    <?php endif; ?>

    <form method="POST" action="./solicitar">

        <!-- COLEGIO -->
        <div class="mb-3">
            <label class="form-label">Colegio</label>
            <select name="colegio" class="form-control" required>
                <option value="">-- Selecciona un colegio --</option>

                <?php foreach ($colegios as $colegio): ?>
                    <option value="<?= $colegio['id'] ?>">
                        <?= $colegio['nombre'] ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- TIPO PRENDA -->
        <div class="mb-3">
            <label class="form-label">Tipo prenda</label>
            <select name="tipoPrenda" class="form-control" required>
                <option value="">-- Selecciona --</option>

                <?php foreach ($tiposPrenda as $tipo): ?>
                    <option value="<?= $tipo['id'] ?>">
                        <?= $tipo['nombre'] ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- ESTADO -->
        <div class="mb-3">
            <label class="form-label">Estado de la prenda</label>
            <select name="estadoPrenda" class="form-control" required>
                <option value="">-- Selecciona --</option>

                <?php foreach ($estados as $estado): ?>
                    <option value="<?= $estado['id'] ?>">
                        <?= $estado['nombre'] ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- TALLA -->
        <div class="mb-3">
            <label class="form-label">Talla</label>
            <select name="talla" class="form-control" required>
                <option value="">--Selecciona--</option>

                <?php foreach ($tallas as $talla): ?>
                    <option value="<?= $talla['id'] ?>">
                        <?= $talla['nombre'] ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- GÉNERO -->
        <div class="mb-3">
            <label class="form-label">Género</label>
            <select name="genero" class="form-control" required>
                <option value="">--Selecciona--</option>

            <?php foreach ($generos as $genero): ?>
                <option value="<?= $genero['id'] ?>">
                    <?= $genero['nombre'] ?>
                </option>
            <?php endforeach; ?>

        </select>
        </div>

        <!-- BOTÓN DE ENVÍO -->

        <button type="submit" class="btn btn-primary w-100">
            Solicitar venta
        </button>

    </form>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>