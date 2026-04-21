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
?>


<main>
    <?php require_once __DIR__ . '/../../../components/component-hero-basico.php'; ?>
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