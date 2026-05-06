<?php require_once __DIR__ . '/../layout/header.php'; ?>

<!-- Variables para evitar warnings si no se pasan desde el controller -->
<?php
$enVenta = $enVenta ?? [];
$vendidas = $vendidas ?? [];
$pendientes = $pendientes ?? [];
$rechazadas = $rechazadas ?? [];

$totalEnVenta = count($enVenta);
$totalVendidas = count($vendidas);
$totalPendientes = count($pendientes);
$totalRechazadas = count($rechazadas);
?>

<main>

    <section class="misventas-hero">
        <div class="misventas-contenedor">
            <span class="home-etiqueta">Panel del vendedor</span>
            <h1>Mis ventas</h1>
            <p>
                Consulta el estado de tus prendas, revisa cuáles están publicadas, pendientes de aprobación,
                vendidas o rechazadas, y controla tus ganancias de forma sencilla.
            </p>
        </div>
    </section>

    <section class="misventas-seccion">
        <div class="misventas-contenedor">

            <div class="misventas-resumen">
                <div class="misventas-resumen-card">
                    <span class="misventas-numero"><?= $totalEnVenta ?></span>
                    <p>En venta</p>
                </div>

                <div class="misventas-resumen-card">
                    <span class="misventas-numero"><?= $totalVendidas ?></span>
                    <p>Vendidas</p>
                </div>

                <div class="misventas-resumen-card">
                    <span class="misventas-numero"><?= $totalPendientes ?></span>
                    <p>Pendientes</p>
                </div>

                <div class="misventas-resumen-card">
                    <span class="misventas-numero"><?= $totalRechazadas ?></span>
                    <p>Rechazadas</p>
                </div>
            </div>

            <div class="misventas-grid">

                <article class="misventas-card">
                    <div class="misventas-card-header">
                        <h2>En venta</h2>
                        <span class="misventas-badge badge-publicada">Publicadas</span>
                    </div>

                    <?php if (empty($enVenta)): ?>
                        <p class="misventas-vacio">No tienes prendas publicadas actualmente.</p>
                    <?php endif; ?>

                    <?php foreach ($enVenta as $p): ?>
                        <div class="misventas-item item-publicada">
                            <div>
                                <h3><?= htmlspecialchars($p['tipo']) ?></h3>
                                <p><?= htmlspecialchars($p['colegio']) ?></p>
                            </div>
                            <strong><?= number_format($p['precio_asignado'], 2, ',', '.') ?> €</strong>
                        </div>
                    <?php endforeach; ?>
                </article>

                <article class="misventas-card">
                    <div class="misventas-card-header">
                        <h2>Vendidas</h2>
                        <span class="misventas-badge badge-vendida">Finalizadas</span>
                    </div>

                    <?php if (empty($vendidas)): ?>
                        <p class="misventas-vacio">Todavía no tienes prendas vendidas.</p>
                    <?php endif; ?>

                    <?php foreach ($vendidas as $p): ?>
                        <div class="misventas-item item-vendida">
                            <div>
                                <h3><?= htmlspecialchars($p['tipo']) ?></h3>
                                <p><?= htmlspecialchars($p['colegio']) ?></p>
                                <small>Precio de venta: <?= number_format($p['precio_asignado'], 2, ',', '.') ?> €</small>
                            </div>

                            <?php if (!empty($p['importe_vendedor'])): ?>
                                <strong class="misventas-ganancia">
                                    <?= number_format($p['importe_vendedor'], 2, ',', '.') ?> € netos
                                </strong>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </article>

                <article class="misventas-card">
                    <div class="misventas-card-header">
                        <h2>Pendientes</h2>
                        <span class="misventas-badge badge-pendiente">En revisión</span>
                    </div>

                    <?php if (empty($pendientes)): ?>
                        <p class="misventas-vacio">No tienes solicitudes pendientes de revisión.</p>
                    <?php endif; ?>

                    <?php foreach ($pendientes as $p): ?>
                        <div class="misventas-item item-pendiente">
                            <div>
                                <h3><?= htmlspecialchars($p['tipo']) ?></h3>
                                <p><?= htmlspecialchars($p['colegio']) ?></p>
                            </div>
                            <strong><?= number_format($p['precio_asignado'], 2, ',', '.') ?> €</strong>
                        </div>
                    <?php endforeach; ?>
                </article>

                <article class="misventas-card">
                    <div class="misventas-card-header">
                        <h2>Rechazadas</h2>
                        <span class="misventas-badge badge-rechazada">No publicadas</span>
                    </div>

                    <?php if (empty($rechazadas)): ?>
                        <p class="misventas-vacio">No tienes prendas rechazadas.</p>
                    <?php endif; ?>

                    <?php foreach ($rechazadas as $p): ?>
                        <div class="misventas-item item-rechazada">
                            <div>
                                <h3><?= htmlspecialchars($p['tipo']) ?></h3>
                                <p><?= htmlspecialchars($p['colegio']) ?></p>
                            </div>
                            <strong><?= number_format($p['precio_asignado'], 2, ',', '.') ?> €</strong>
                        </div>
                    <?php endforeach; ?>
                </article>

            </div>
        </div>
    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>