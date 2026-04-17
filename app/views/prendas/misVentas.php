<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4">

    <h2 class="text-center mb-4">Mis prendas</h2>

    <div class="row">

        <!-- EN VENTA -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 h-100">
                <h5 class="text-center text-success mb-3">En venta</h5>

                <?php if (empty($enVenta)): ?>
                    <p class="text-center text-muted">No hay prendas</p>
                <?php endif; ?>

                <?php foreach ($enVenta as $p): ?>
                    <div class="border rounded p-2 mb-2 bg-success-subtle">
                        <strong><?= htmlspecialchars($p['tipo']) ?></strong><br>
                        <?= htmlspecialchars($p['colegio']) ?><br>
                        <?= $p['precio_asignado'] ?> €
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- VENDIDAS -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 h-100">
                <h5 class="text-center text-danger mb-3">Vendidas</h5>

                <?php if (empty($vendidas)): ?>
                    <p class="text-center text-muted">No hay prendas</p>
                <?php endif; ?>

                <?php foreach ($vendidas as $p): ?>
                    <div class="border rounded p-2 mb-2 bg-danger-subtle">
                        <strong><?= htmlspecialchars($p['tipo']) ?></strong><br>
                        <?= htmlspecialchars($p['colegio']) ?><br>
                        <?= $p['precio_asignado'] ?> €
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- PENDIENTES -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 h-100">
                <h5 class="text-center text-warning mb-3">Pendientes</h5>

                <?php if (empty($pendientes)): ?>
                    <p class="text-center text-muted">No hay prendas</p>
                <?php endif; ?>

                <?php foreach ($pendientes as $p): ?>
                    <div class="border rounded p-2 mb-2 bg-warning-subtle">
                        <strong><?= htmlspecialchars($p['tipo']) ?></strong><br>
                        <?= htmlspecialchars($p['colegio']) ?><br>
                        <?= $p['precio_asignado'] ?> €
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- RECHAZADAS -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 h-100">
                <h5 class="text-center text-secondary mb-3">Rechazadas</h5>

                <?php if (empty($rechazadas)): ?>
                    <p class="text-center text-muted">No hay prendas</p>
                <?php endif; ?>

                <?php foreach ($rechazadas as $p): ?>
                    <div class="border rounded p-2 mb-2 bg-light">
                        <strong><?= htmlspecialchars($p['tipo']) ?></strong><br>
                        <?= htmlspecialchars($p['colegio']) ?><br>
                        <?= $p['precio_asignado'] ?> €
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>