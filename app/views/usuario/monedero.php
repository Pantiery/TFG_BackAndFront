<?php require_once __DIR__ . '/../layout/header.php'; ?>
<!-- Variables para que no de error -->
<?php
$total = $total ?? 0;
$ventas = $ventas ?? [];
?>

<main>

    <section class="monedero-hero">
        <div class="monedero-contenedor">
            <span class="home-etiqueta">Saldo de ventas</span>
            <h1>Mi monedero</h1>
            <p>
                Consulta el dinero pendiente de recibir por tus prendas vendidas. El importe aparece como pendiente
                hasta que el administrador marque el pago como realizado.
            </p>
        </div>
    </section>

    <section class="monedero-seccion">
        <div class="monedero-contenedor monedero-grid">

            <aside class="monedero-resumen-card">
                <span class="monedero-icono">€</span>
                <p class="monedero-label">Saldo pendiente</p>
                <h2><?= number_format($total, 2, ',', '.') ?> €</h2>
                <p class="monedero-texto">
                    Este total corresponde a las ventas que todavía están pendientes de pago.
                </p>
            </aside>

            <section class="monedero-listado-card">
                <div class="monedero-listado-header">
                    <div>
                        <h2>Ventas pendientes de cobro</h2>
                        <p>Prendas vendidas cuyo pago aún no ha sido confirmado.</p>
                    </div>

                    <span class="monedero-badge">
                        <?= count($ventas) ?> pendiente<?= count($ventas) === 1 ? '' : 's' ?>
                    </span>
                </div>

                <?php if (empty($ventas)): ?>
                    <div class="monedero-vacio">
                        <h3>No tienes dinero pendiente</h3>
                        <p>Cuando vendas una prenda y el pago esté pendiente, aparecerá aquí.</p>
                    </div>
                <?php else: ?>

                    <div class="monedero-listado">
                        <?php foreach ($ventas as $venta): ?>

                            <article class="monedero-item">
                                <div class="monedero-item-info">
                                    <?php if (!empty($venta['imagen'])): ?>
                                        <img src="<?= \App\Config\App::baseUrl() . $venta['imagen'] ?>"
                                             alt="<?= htmlspecialchars($venta['tipo']) ?>"
                                             class="monedero-img">
                                    <?php else: ?>
                                        <div class="monedero-img monedero-img-placeholder">Sin imagen</div>
                                    <?php endif; ?>

                                    <div>
                                        <h3><?= htmlspecialchars($venta['tipo']) ?></h3>
                                        <p><?= htmlspecialchars($venta['colegio']) ?></p>
                                        <span class="monedero-estado">Pendiente de pago</span>
                                    </div>
                                </div>

                                <div class="monedero-importe">
                                    +<?= number_format($venta['importe_vendedor'], 2, ',', '.') ?> €
                                </div>
                            </article>

                        <?php endforeach; ?>
                    </div>

                <?php endif; ?>
            </section>

        </div>
    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>