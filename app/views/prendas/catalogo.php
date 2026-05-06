<?php

$titulo = 'Catálogo de Prendas';
$tituloHero = 'Explora nuestro catálogo de prendas';
$subtituloHero = 'Encuentra las mejores prendas de segunda mano para tu uniforme escolar.';
$imagenes = [
    '/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo1.jpg',
    '/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo2.avif',
    '/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo3.webp',
];

require_once __DIR__ . '/../layout/header.php';

$colegios = $colegios ?? [];
$tiposPrenda = $tiposPrenda ?? [];
$estadosCalidad = $estadosCalidad ?? [];

// nombres unificados
$filtroColegio = $_GET['colegio'] ?? '';
$filtroTipo = $_GET['tipo'] ?? '';
$filtroEstado = $_GET['estado'] ?? '';
?>

<main class="catalogo-main">
    <?php require_once __DIR__ . '/../../../components/component-hero-basico.php'; ?>

    <section class="catalogo-presentacion">
        <div class="catalogo-contenedor">
            <span class="home-etiqueta">Catálogo UniColegio</span>
            <h1>Prendas disponibles</h1>
            <p>
                Consulta los uniformes publicados por las familias. Todas las prendas han sido revisadas antes de aparecer en el catálogo y su precio se calcula de forma estándar según el tipo y el estado.
            </p>
        </div>
    </section>

    <section class="catalogo-filtros-seccion">
        <div class="catalogo-contenedor">
            <div class="catalogo-filtros-card">
                <div class="catalogo-filtros-cabecera">
                    <h2>Buscar prendas</h2>
                    <p>Filtra por colegio, tipo de prenda o estado de conservación.</p>
                </div>

                <!-- FORMULARIO DE FILTROS -->
                <form method="GET" class="catalogo-filtros-form">

                    <!-- COLEGIO -->
                    <div class="catalogo-campo">
                        <label class="form-label">Colegio</label>
                        <select name="colegio" class="form-select"
                            onchange="window.location.href='?colegio=' + this.value">

                            <option value="">Todos los colegios</option>

                            <?php foreach ($colegios as $colegio): ?>
                                <option value="<?= $colegio['id'] ?>"
                                    <?= (string)$filtroColegio === (string)$colegio['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($colegio['nombre']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- TIPO PRENDA -->
                    <div class="catalogo-campo">
                        <label class="form-label">Tipo de prenda</label>
                        <select name="tipo" class="form-select"
                            onchange="window.location.href='?colegio=<?= $filtroColegio ?>&tipo=' + this.value">

                            <option value="">Todos los tipos</option>

                            <?php foreach ($tiposPrenda as $tipo): ?>
                                <option value="<?= $tipo['id'] ?>"
                                    <?= (string)$filtroTipo === (string)$tipo['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($tipo['nombre']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- ESTADO -->
                    <div class="catalogo-campo">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select"
                            onchange="window.location.href='?colegio=<?= $filtroColegio ?>&tipo=<?= $filtroTipo ?>&estado=' + this.value">

                            <option value="">Todos los estados</option>

                            <?php foreach ($estadosCalidad as $estado): ?>
                                <option value="<?= $estado['id'] ?>"
                                    <?= (string)$filtroEstado === (string)$estado['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars(ucfirst($estado['nombre'])) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- BOTÓN -->
                    <div class="catalogo-campo catalogo-campo-boton">
                        <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>"
                            class="btn btn-catalogo-limpiar">
                            Limpiar filtros
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <div class="catalogo-contenedor catalogo-mensajes">

        <!-- MENSAJES DE ÉXITO O ERROR -->
        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= htmlspecialchars($_SESSION['mensaje_exito']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['mensaje_exito']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= htmlspecialchars($_SESSION['mensaje_error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['mensaje_error']); ?>
        <?php endif; ?>

    </div>

    <section class="catalogo-listado-seccion">
        <div class="catalogo-contenedor">
            <div class="catalogo-listado-cabecera">
                <div>
                    <span class="home-etiqueta">Uniformes publicados</span>
                    <h2>Resultados del catálogo</h2>
                </div>
                <p>Selecciona una prenda para ver más información o añadirla directamente al carrito.</p>
            </div>
        </div>

        <?php require_once __DIR__ . '/../../../components/component-catalogo-prendas.php'; ?>
    </section>

</main>

<script src="<?= \App\Config\App::baseUrl() ?>/assets/js/mensajes.js"></script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>