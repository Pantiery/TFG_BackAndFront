<?php
/** @var array $imagenes */
/** @var string $tituloHero */
/** @var string $subtituloHero */
?>

<!-- Seccion-Hero -->
<section class="hero">

  <!-- Carousel fondo -->
  <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">

    <!-- Indicadores -->
    <div class="carousel-indicators">
      <?php foreach ($imagenes as $index => $img): ?>
        <button 
          type="button" 
          data-bs-target="#heroCarousel" 
          data-bs-slide-to="<?= $index ?>" 
          class="<?= $index === 0 ? 'active' : '' ?>" 
          aria-current="<?= $index === 0 ? 'true' : 'false' ?>">
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Imágenes -->
    <div class="carousel-inner">
      <?php foreach ($imagenes as $index => $img): ?>
        
        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
          <img src="<?= $img ?>" class="d-block w-100">
        </div>

      <?php endforeach; ?>
    </div>

    <!-- Botón anterior -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>

    <!-- Botón siguiente -->
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>

  </div>

  <!-- Contenido del hero -->
  <div class="hero-principal hero-content text-center">

        <img src="<?= \App\Config\App::url('/assets/img/logo/logoUniformes.png') ?>" alt="Icono" class="mb-3">

    <h1 class="seccion-titulo display-4">
      <?= $tituloHero ?>
    </h1>

    <h2 class="seccion-subtitulo">
      <?= $subtituloHero ?>
    </h2>

  </div>

</section>