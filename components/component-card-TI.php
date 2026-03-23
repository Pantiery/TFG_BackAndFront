<section class="hero-section py-5">
  <div class="container seccion-montaña">
    <div class="row align-items-center g-5">

   <?php if (!empty($tituloExtra)): ?>
                <h2 class="seccion-subtitulo text-center mb-4"><?= $tituloExtra ?></h2>
            <?php endif; ?>

      <!-- Texto -->
      <div class="col-12 col-md-6">
        <h1 class="seccion-titulo"><?= $titulo ?></h1>

        <p class="seccion-texto mt-3">
          <?= $descripcion ?>
        </p>
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