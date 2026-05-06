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
    <section class="solicitar-hero">
        <div class="solicitar-contenedor">
            <span class="home-etiqueta">Venta de uniformes</span>
            <h1>Solicita la venta de una prenda</h1>
            <p>
                Rellena el formulario con los datos de la prenda. Nuestro equipo revisará la solicitud,
                asignará el precio estándar correspondiente y, si todo es correcto, la publicará en el catálogo.
            </p>
        </div>
    </section>

    <section class="solicitar-seccion">
        <div class="solicitar-contenedor solicitar-grid">

            <div class="solicitar-info">
                <h2>Antes de enviar la solicitud</h2>
                <p>
                    UniColegio revisa cada prenda antes de ponerla a la venta para asegurar que se encuentra
                    en buen estado y pertenece a uno de los colegios colaboradores.
                </p>

                <div class="solicitar-info-card">
                    <span class="home-numero">1</span>
                    <div>
                        <h3>Precio automático</h3>
                        <p>El precio no lo decide el vendedor. Se calcula según el tipo de prenda y su estado.</p>
                    </div>
                </div>

                <div class="solicitar-info-card">
                    <span class="home-numero">2</span>
                    <div>
                        <h3>Comisión fija</h3>
                        <p>La plataforma aplica una comisión del 10% para cubrir la gestión del servicio.</p>
                    </div>
                </div>

                <div class="solicitar-info-card">
                    <span class="home-numero">3</span>
                    <div>
                        <h3>Revisión previa</h3>
                        <p>Un administrador aprobará o rechazará la solicitud antes de publicarla.</p>
                    </div>
                </div>
            </div>

            <div class="solicitar-form-card">

                <?php if (isset($_SESSION['mensaje_exito'])): ?>
                    <div class="alert alert-success text-center">
                        <?= $_SESSION['mensaje_exito'] ?>
                    </div>
                    <?php unset($_SESSION['mensaje_exito']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['mensaje_error'])): ?>
                    <div class="alert alert-danger text-center">
                        <?= $_SESSION['mensaje_error'] ?>
                    </div>
                    <?php unset($_SESSION['mensaje_error']); ?>
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