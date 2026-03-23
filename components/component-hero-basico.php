<!-- Seccion-Hero -->
<section class="hero">

  <!-- Carousel fondo -->
  <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">

      <?php foreach ($imagenesHero as $index => $imagen): ?>
        
        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
          <img src="<?= $imagen ?>" class="d-block w-100">
        </div>

      <?php endforeach; ?>

    </div>
  </div>

  <!-- Contenido del hero -->
  <div class="hero-principal hero-content text-center">

      <h1 class="seccion-titulo display-4">
        <?= $tituloHero ?>
      </h1>

      <h2 class="seccion-subtitulo">
        <?= $subtituloHero ?>
      </h2>

  </div>

</section>