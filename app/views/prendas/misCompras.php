<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h2>Mis compras</h2>

    <?php if (empty($compras)): ?>
        <p>No has realizado compras todavía.</p>
    <?php else: ?>

        <?php
        $compras = $compras ?? [];

        $ventasAgrupadas = [];

        foreach ($compras as $compra) {
            $ventasAgrupadas[$compra['venta_id']][] = $compra;
        }
        ?>

        <?php $contador = 1; ?>

        <?php foreach ($ventasAgrupadas as $ventaId => $productos): ?>

            <div class="card mb-3 p-3">

                <h5>Compra <?= $contador ?> (ID: <?= $ventaId ?>)</h5>

                <?php $contador++; ?>

                <h5>
                    <?= date('d/m/Y', strtotime($productos[0]['fecha'])) ?>
                </h5>

                <p><strong>Total:</strong>
                    <?= number_format($productos[0]['total'], 2) ?> €
                </p>

                <?php foreach ($productos as $producto): ?>

                    <div class="d-flex gap-3 mb-2">

                        <?php if (!empty($producto['imagen'])): ?>
                            <img src="<?= \App\Config\App::baseUrl() . $producto['imagen'] ?>" width="80">
                        <?php endif; ?>

                        <div>
                            <p>
                                <?= htmlspecialchars($producto['tipo']) ?> - <?= htmlspecialchars($producto['colegio']) ?>
                            </p>
                            <p>
                                Precio: <?= number_format($producto['precio_unitario'], 2) ?> €
                            </p>
                        </div>

                    </div>

                <?php endforeach; ?>
                <p class="text-muted small">
                    <?= count($productos) ?> producto(s)
                </p>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>