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
            <?= $_SESSION['mensaje_exito'] ?>
        </div>
        <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_campos'])): ?>
        <div class="alert alert-danger text-center">
            <?= $_SESSION['error_campos'] ?>
        </div>
        <?php unset($_SESSION['error_campos']); ?>
    <?php endif; ?>

                <h2>Datos de la prenda</h2>
                <p class="solicitar-form-subtitulo">
                    Selecciona primero el colegio para cargar las opciones disponibles.
                </p>

                <form method="GET" class="mb-4">
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

                <form enctype="multipart/form-data" method="POST" action="./solicitar">
                    <input type="hidden" name="colegio" value="<?= $_GET['colegio'] ?? '' ?>">

                    <div class="solicitar-form-grid">
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
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagen de la prenda</label>
                        <input type="file" name="archivoEnviado" class="form-control casilla" required>
                    </div>

                    <div class="solicitar-aviso">
                        <p>
                            El precio se asignará automáticamente según el tipo y estado de la prenda.
                            La comisión de gestión será del 10%.
                        </p>
                        <p>
                            La venta está sujeta a la aprobación del equipo de administración.
                        </p>
                    </div>

                    <button type="submit" class="btn btn-home btn-home-principal w-100">
                        Enviar solicitud de venta
                    </button>
                </form>
            </div>

        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>