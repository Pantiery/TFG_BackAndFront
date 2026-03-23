<<section class="hero-section py-5">
    <div class="container seccion-montaña">
        <div class="row align-items-center g-4">

        <?php if(!empty($tituloExtra)): ?>
<h2 class="seccion-subtitulo text-center mb-4"><?= $tituloExtra ?></h2>
<?php endif; ?>

            <!-- Imagen -->
            <div class="col-12 col-md-6">
                <div class="hero-img-wrapper">
                    <img src="<?= $imagen ?>" alt="<?= $titulo ?>" class="img-fluid rounded <?= $claseExtra ?>">
                </div>
            </div>

            <!-- Texto -->
            <div class="col-12 col-md-6 text-md-start ms-md-auto">
                <h1 class="hero-title"><?= $titulo ?></h1>

                <p class="hero-text mt-3">
                    <?= $descripcion ?>
                </p>

        </div>
    </div>
</section>