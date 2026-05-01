<?php

$titulo = 'Catálogo de Prendas';
$tituloHero = 'Explora nuestro catálogo de prendas';
$subtituloHero = 'Encuentra las mejores prendas de segunda mano para tu uniforme escolar.';
$imagenes = [
    '/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo1.jpg',
    '/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo2.webp',
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

<main>
    <?php require_once __DIR__ . '/../../../components/component-hero-basico.php'; ?>

    <!-- // Sección de filtros -->
    <section class="w-100 mt-4 py-4 bg-light border-bottom">

        <div class="container">

            <div class="text-center mb-3">
                <h2 class="h4 mb-1 text-dark">Buscar prendas</h2>
                <p class="text-muted mb-0">Filtra por colegio, tipo de prenda o estado.</p>
            </div>

            <!-- FORMULARIO DE FILTROS -->
            <form method="GET" class="row g-3 justify-content-center align-items-end">

                <!-- COLEGIO -->
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label text-dark">Colegio</label>
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
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label text-dark">Tipo de prenda</label>
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
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label text-dark">Estado</label>
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
                <div class="col-12 col-md-6 col-lg-3 d-flex">
                    <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>"
                        class="btn btn-outline-secondary w-100">
                        Limpiar
                    </a>
                </div>

            </form>

        </div>

    </section>

    <div class="container mt-3">

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

    <?php require_once __DIR__ . '/../../../components/component-catalogo-prendas.php'; ?>

</main>

<script src="<?= \App\Config\App::baseUrl() ?>/assets/js/mensajes.js"></script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>