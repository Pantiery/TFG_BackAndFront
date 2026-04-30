<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <h2 class="mb-4">Mi monedero</h2>

    <!-- TOTAL -->
    <div class="card p-4 mb-4 shadow-sm text-center">
        <h4 class="text-muted">Saldo pendiente</h4>
        <h2 class="text-success fw-bold">
            <?= number_format($total, 2, ',', '.') ?> €
        </h2>
    </div>

    <!-- LISTADO -->
    <div class="card p-4 shadow-sm">

        <h5 class="mb-3">Ventas pendientes de cobro</h5>

        <?php if (empty($ventas)): ?>
            <p class="text-muted">No tienes dinero pendiente.</p>
        <?php else: ?>

            <?php foreach ($ventas as $venta): ?>

                <div class="border-bottom py-3 d-flex align-items-center gap-3">

                    <!-- IMAGEN -->
                    <?php if (!empty($venta['imagen'])): ?>
                        <img src="<?= \App\Config\App::baseUrl() . $venta['imagen'] ?>" width="70" class="rounded">
                    <?php endif; ?>

                    <!-- INFO -->
                    <div class="flex-grow-1">
                        <strong><?= htmlspecialchars($venta['tipo']) ?></strong><br>
                        <span class="text-muted small">
                            <?= htmlspecialchars($venta['colegio']) ?>
                        </span>
                    </div>

                    <!-- IMPORTE -->
                    <div class="text-success fw-bold">
                        +<?= number_format($venta['importe_vendedor'], 2, ',', '.') ?> €
                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>
<br>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>