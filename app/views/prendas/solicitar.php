<?php require_once __DIR__ . '/../layout/header.php'; ?>

<!-- Variables para evitar warnings si no se pasan desde el controller -->
<?php
$colegios = $colegios ?? [];
$tiposPrenda = $tiposPrenda ?? [];
$estados = $estados ?? [];
$tallas = $tallas ?? [];
$generos = $generos ?? [];
?>

<main>

<div class="container mt-4 mb-4">

    <!-- MENSAJES EXITO O ERROR -->
    <?php if (isset($_SESSION['success_prenda'])): ?>
        <div class="alert alert-success text-center">
            <?= $_SESSION['success_prenda'] ?>
        </div>
        <?php unset($_SESSION['success_prenda']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_campos'])): ?>
        <div class="alert alert-danger text-center">
            <?= $_SESSION['error_campos'] ?>
        </div>
        <?php unset($_SESSION['error_campos']); ?>
    <?php endif; ?>

    <h2 class="text-center mb-4">Solicitar venta de prenda</h2>

    <div class="d-flex justify-content-center">

        <div style="max-width: 500px; width: 100%;">

            <div class="card p-4 formulario-solicitar">

                <!-- FORM 1: FILTRO -->
                <form method="GET">

                    <div class="mb-3">
                        <label class="form-label">Colegio</label>
                        <select name="colegio" class="form-control casilla" onchange="this.form.submit()">
                            <option value="">-- Selecciona un colegio --</option>

                            <?php foreach ($colegios as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= (isset($_GET['colegio']) && $_GET['colegio'] == $c['id']) ? 'selected' : '' ?>>
                                    <?= $c['nombre'] ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                </form>

                <!-- FORM 2: ENVÍO -->
                <form enctype="multipart/form-data" method="POST" action="./solicitar">

                    <input type="hidden" name="colegio" value="<?= $_GET['colegio'] ?? '' ?>">

                    <div class="mb-3">
                        <label class="form-label">Tipo prenda</label>
                        <select name="tipoPrenda" class="form-control casilla" required>
                            <option value="">-- Selecciona --</option>
                            <?php foreach ($tiposPrenda as $tipo): ?>
                                <option value="<?= $tipo['id'] ?>">
                                    <?= $tipo['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estadoPrenda" class="form-control casilla" required>
                            <option value="">-- Selecciona --</option>
                            <?php foreach ($estados as $estado): ?>
                                <option value="<?= $estado['id'] ?>">
                                    <?= $estado['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Talla</label>
                        <select name="talla" class="form-control casilla" required>
                            <option value="">-- Selecciona --</option>
                            <?php foreach ($tallas as $talla): ?>
                                <option value="<?= $talla['id'] ?>">
                                    <?= $talla['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Género</label>
                        <select name="genero" class="form-control casilla" required>
                            <option value="">-- Selecciona --</option>
                            <?php foreach ($generos as $genero): ?>
                                <option value="<?= $genero['id'] ?>">
                                    <?= $genero['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Archivo</label>
                        <input type="file" name="archivoEnviado" class="form-control" required>
                    </div>

                    <p class="small text-center parrafo-info">
                        El precio se asignará automáticamente según el tipo y estado de la prenda y tendra una comisión del 10% para cubrir los gastos de gestión y mantenimiento de la plataforma.
                    </p>
                    <p class="small text-center parrafo-info">
                        La venta esta sujeta a la aprobación del equipo de administración, que verificará que la prenda cumpla con los requisitos de calidad y autenticidad.
                    </p>

                    <button type="submit" class="btn btn-primary w-100">
                        Solicitar venta
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>