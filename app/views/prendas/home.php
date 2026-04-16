<?php

$titulo = "Home";
$tituloHero = "Bienvenido a nuestra tienda de prendas";
$subtituloHero = "Descubre las últimas tendencias en moda y encuentra tu estilo único con nosotros.";

$imagenes = [
    "/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-home.webp",
    "/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-home2.jpg",
    "/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-home3.jpg"
];

require_once __DIR__ . '/../layout/header.php';
?>

<main>
    <?php require_once __DIR__ . '/../../../components/component-hero-basico.php'; ?>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>