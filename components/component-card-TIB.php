<section class="hero-section py-5">
  <div class="container">
    <div class="row align-items-center g-4">

      <!-- Texto -->
      <div class="col-12 col-md-6">
        <h1 class="hero-title"><?= $titulo ?></h1>

        <p class="hero-text mt-3">
          <?= $descripcion ?>
        </p>

        <div class="d-flex gap-2 mt-4">
          <button class="btn btn-verde-interno"><?= $boton1 ?></button>
          <button class="btn btn-outline-verde-interno"><?= $boton2 ?></button>
        </div>
      </div>

      <!-- Imagen -->
      <div class="col-12 col-md-6">
        <div class="hero-img-wrapper">
          <img src="<?= $imagen ?>" alt="<?= $titulo ?>" class="img-fluid rounded">
        </div>
      </div>

    </div>
  </div>
</section>