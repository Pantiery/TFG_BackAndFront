<?php

$titulo = "Catálogo de Prendas";
$tituloHero = "Explora nuestro catálogo de prendas";        
$subtituloHero = "Encuentra las mejores prendas de segunda mano para tu uniforme escolar.";
$imagenes = [
    "/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo1.jpg",
    "/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo2.webp",
    "/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo3.webp"
];

require_once __DIR__ . '/../layout/header.php';

$colegios = $colegios ?? [];
$tiposPrenda = $tiposPrenda ?? [];
$estadosCalidad = $estadosCalidad ?? [];

$filtroColegio = $_GET['colegio_id'] ?? '';
$filtroTipo = $_GET['tipo_prenda_id'] ?? '';
$filtroEstado = $_GET['estado_calidad_id'] ?? '';
?>


<main>
    <?php require_once __DIR__ . '/../../../components/component-hero-basico.php'; ?>

    <section class="w-100 mt-4 py-4 bg-light border-bottom">
        <div class="px-3 px-md-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-3 gap-2">
                    <div>
                        <h2 class="h4 mb-1 text-dark">Buscar prendas</h2>
                        <p class="text-muted mb-0">Filtra por colegio, tipo de prenda o estado.</p>
                    </div>
                </div>

                <form method="GET" action="" class="row g-3 align-items-end">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="colegio_id" class="form-label text-dark">Colegio</label>
                        <select name="colegio_id" id="colegio_id" class="form-select">
                            <option value="">Todos los colegios</option>
                            <?php foreach ($colegios as $colegio): ?>
                                <option value="<?= htmlspecialchars($colegio['id']) ?>"
                                    <?= (string)$filtroColegio === (string)$colegio['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($colegio['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="tipo_prenda_id" class="form-label text-dark">Tipo de prenda</label>
                        <select name="tipo_prenda_id" id="tipo_prenda_id" class="form-select">
                            <option value="">Todos los tipos</option>
                            <?php foreach ($tiposPrenda as $tipo): ?>
                                <option value="<?= htmlspecialchars($tipo['id']) ?>"
                                    <?= (string)$filtroTipo === (string)$tipo['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($tipo['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="estado_calidad_id" class="form-label text-dark">Estado</label>
                        <select name="estado_calidad_id" id="estado_calidad_id" class="form-select">
                            <option value="">Todos los estados</option>
                            <?php foreach ($estadosCalidad as $estado): ?>
                                <option value="<?= htmlspecialchars($estado['id']) ?>"
                                    <?= (string)$filtroEstado === (string)$estado['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars(ucfirst($estado['nombre'])) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                        <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </div>
                </form>
        </div>
    </section>

    <div class="container mt-3">
        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div id="mensajeExito" class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['mensaje_exito']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['mensaje_exito']); ?>
        <?php endif; ?>
    
        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <div id="mensajeError" class="alert alert-danger alert-dismissible fade show" role="alert">
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