<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h2>Mis compras</h2>

    <?php if (empty($compras)): ?>
        <p>No has realizado compras todavía.</p>
    <?php else: ?>

        <?php foreach ($compras as $compra): ?>

            <div class="card mb-3 p-3">
                <h5>Venta #<?= $compra['venta_id'] ?> - <?= $compra['fecha'] ?></h5>

                <p><strong>Total:</strong> <?= number_format($compra['total'], 2) ?> €</p>

                <div class="d-flex gap-3">

                    <img src="<?= \App\Config\App::baseUrl() . $compra['imagen'] ?>" width="100">

                    <div>
                        <p><?= $compra['tipo'] ?> - <?= $compra['colegio'] ?></p>
                        <p>Precio: <?= number_format($compra['precio_unitario'], 2) ?> €</p>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>