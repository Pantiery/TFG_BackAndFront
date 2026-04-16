<?php

$titulo = "Catálogo de Prendas";
$tituloHero = "Explora nuestro catálogo de prendas";        
$subtituloHero = "Encuentra las mejores prendas de segunda mano para tu uniforme escolar.";
$imagenes = [
    "/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo1.jpg",
    "/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo2.jpg",
    "/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-catalogo3.jpg"
];

require_once __DIR__ . '/../layout/header.php';
?>

<main>
    <?php require_once __DIR__ . '/../../../components/component-hero-basico.php'; ?>
    <?php require_once __DIR__ . '/../../../components/component-catalogo-prendas.php'; ?>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>