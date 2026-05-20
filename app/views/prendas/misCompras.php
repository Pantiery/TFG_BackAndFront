<?php require_once __DIR__ . '/../layout/header.php'; ?>
<main>
    <section class="miscompras-hero">
        <div class="miscompras-contenedor">
            
            <h1>Mis compras</h1>
            <p>
                Consulta las compras realizadas en UniColegio, revisa las prendas adquiridas
                y comprueba el importe total de cada pedido.
            </p>
        </div>
    </section>

    <section class="miscompras-seccion">
        <div class="miscompras-contenedor">

            <?php if (empty($compras)): ?>

                <div class="miscompras-vacio">
                    <h2>Aún no has realizado ninguna compra</h2>
                    <p>
                        Cuando compres una prenda del catálogo, aparecerá aquí con su fecha,
                        precio y colegio correspondiente.
                    </p>
                    <a href="<?= \App\Config\App::baseUrl() ?>/prendas/catalogo" class="btn-home btn-home-principal">
                        Ir al catálogo
                    </a>
                </div>

            <?php else: ?>

                <?php
                $compras = $compras ?? [];
                $ventasAgrupadas = [];

                foreach ($compras as $compra) {
                    $ventasAgrupadas[$compra['venta_id']][] = $compra;
                }

                $ventasAgrupadas = array_reverse($ventasAgrupadas, true);

                $totalCompras = count($ventasAgrupadas);
                $totalPrendas = count($compras);
                $totalGastado = 0;

                foreach ($ventasAgrupadas as $productosResumen) {
                    $totalGastado += (float) $productosResumen[0]['total'];
                }
                ?>

                <div class="miscompras-resumen">
                    <div class="miscompras-resumen-card">
                        <span class="miscompras-numero"><?= $totalCompras ?></span>
                        <p>Compra(s) realizadas</p>
                    </div>

                    <div class="miscompras-resumen-card">
                        <span class="miscompras-numero"><?= $totalPrendas ?></span>
                        <p>Prenda(s) compradas</p>
                    </div>

                    <div class="miscompras-resumen-card">
                        <span class="miscompras-numero"><?= number_format($totalGastado, 2, ',', '.') ?> €</span>
                        <p>Total gastado</p>
                    </div>
                </div>

                <div class="miscompras-cabecera-listado">
                    <div>
                        <span class="miscompras-etiqueta">Compras registradas</span>
                        <h2>Historial de pedidos</h2>
                    </div>
                    <p>
                        Cada tarjeta agrupa las prendas incluidas en una misma compra.
                    </p>
                </div>

                <div class="miscompras-grid">
                    <?php $contador = 1; ?>

                    <?php foreach ($ventasAgrupadas as $ventaId => $productos): ?>

                        <article class="miscompras-card">
                            <div class="miscompras-card-header">
                                <div>
                                    <h3>Compra <?= $contador ?></h3>
                                </div>

                                <span class="miscompras-fecha">Fecha de compra: 
                                    <?= date('d/m/Y', strtotime($productos[0]['fecha'])) ?>
                                </span>
                            </div>

                            <?php $contador++; ?>

                            <div class="miscompras-total">
                                <span>Total</span>
                                <strong><?= number_format($productos[0]['total'], 2, ',', '.') ?> €</strong>
                            </div>

                            <div class="miscompras-productos">
                                <?php foreach ($productos as $producto): ?>

                                    <div class="miscompras-producto">

                                        <?php if (!empty($producto['imagen'])): ?>
                                            <img src="<?= \App\Config\App::baseUrl() . $producto['imagen'] ?>" alt="Imagen de la prenda">
                                        <?php else: ?>
                                            <div class="miscompras-img-placeholder">Sin imagen</div>
                                        <?php endif; ?>

                                        <div class="miscompras-producto-info">
                                            <h4>
                                                <?= htmlspecialchars($producto['tipo']) ?>
                                            </h4>
                                            <p>
                                                <strong>Colegio:</strong> <?= htmlspecialchars($producto['colegio']) ?>
                                            </p>
                                            <p>
                                                <strong>Precio:</strong> <?= number_format($producto['precio_unitario'], 2, ',', '.') ?> €
                                            </p>
                                        </div>

                                    </div>

                                <?php endforeach; ?>
                            </div>

                            <p class="miscompras-cantidad">
                                <?= count($productos) ?> producto(s)
                            </p>
                        </article>

                    <?php endforeach; ?>
                </div>

            <?php endif; ?>

        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>