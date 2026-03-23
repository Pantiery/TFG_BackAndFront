<section class="hero">

  <!-- Carousel fondo -->
  <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">

      <?php foreach ($imagenesHero as $index => $img) { ?>
        <div class="carousel-item <?php if ($index == 0)
          echo 'active'; ?>">
          <img src="<?php echo $img; ?>" class="d-block w-100">
        </div>
      <?php } ?>

    </div>
  </div>

  <!-- Contenido del hero -->
  <div class="hero-principal hero-content text-center">
    <h1 class="seccion-titulo display-4"><?php echo $tituloHero; ?></h1>

    <a class="text-decoration-none" href="<?php echo $linkSubtitulo; ?>">
      <h2 class="seccion-subtitulo"><?php echo $subtituloHero; ?></h2>
    </a>

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-3 mt-3">

      <a href="<?php echo $linkBoton1; ?>" class="boton-hero btn btn-naranja">
        <?php echo $textoBoton1; ?>
      </a>

      <a href="<?php echo $linkBoton2; ?>" class="boton-hero btn btn-outline-blanco">
        <?php echo $textoBoton2; ?>
      </a>

    </div>
  </div>

</section>