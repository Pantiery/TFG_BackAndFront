<?php if (isset($_SESSION['mensaje_error'])): ?>

    <div class="alert alert-danger alert-dismissible fade show text-center">

        <?= htmlspecialchars($_SESSION['mensaje_error']) ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    <?php unset($_SESSION['mensaje_error']); ?>

<?php endif; ?>

<?php if (isset($_SESSION['mensaje_exito'])): ?>

    <div class="alert alert-success alert-dismissible fade show text-center">

        <?= htmlspecialchars($_SESSION['mensaje_exito']) ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    <?php unset($_SESSION['mensaje_exito']); ?>

<?php endif; ?>