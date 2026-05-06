<div class="container mt-5 pt-5">

    <?php if (isset($_SESSION['mensaje_error'])): ?>
        <div class="alert alert-danger text-center">
            <?= $_SESSION['mensaje_error'] ?>
        </div>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <div class="alert alert-success text-center">
            <?= $_SESSION['mensaje_exito'] ?>
        </div>
        <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>

</div>