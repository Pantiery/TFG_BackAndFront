<?php require_once __DIR__ . '/../layout/header.php'; ?>

<?php $productos = $productos ?? []; ?>

<div class="container">
    <br>
    <!-- TITULO -->
    <div class="mb-4">
        <h2 class="fw-bold mb-2">Tu carrito</h2>
        <p class="mb-2">Revisa tus productos antes de finalizar la compra.</p>
    </div>

    <div class="row g-4">

        <!-- COLUMNA IZQUIERDA -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 carrito-card">
                
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h3 class="fs-4 fw-semibold mb-0">Productos añadidos</h3>
                    <span class="badge text-bg-dark rounded-pill px-3 py-2">
                        <?= count($productos) ?> producto(s)
                    </span>
                </div>

                <!-- PRODUCTOS -->
                <?php if (empty($productos)): ?>
                    <p>No tienes productos en el carrito.</p>
                <?php else: ?>

                    <?php foreach ($productos as $producto): ?>

                        <div class="row align-items-center carrito-item py-4 border-bottom">

                            <!-- IMAGEN -->
                            <div class="col-md-3 mb-3 mb-md-0">
                                <?php if (!empty($producto['imagen'])): ?>
                                    <img src="<?= \App\Config\App::baseUrl() . $producto['imagen'] ?>"
                                        class="img-fluid rounded-4 w-100 producto-img">
                                <?php else: ?>
                                    <div class="bg-light p-4 text-center rounded-4">
                                        Sin imagen
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- INFO -->
                            <div class="col-md-6">

                                <h4 class="fs-5 fw-bold mb-2">
                                    <?= $producto['tipo'] ?> - <?= $producto['colegio_nombre'] ?>
                                </h4>

                                <div class="d-flex flex-wrap gap-3 small text-secondary mb-3">
                                    <span>
                                        <strong>Estado:</strong> 
                                        <?= htmlspecialchars($producto['estado_publicacion']) ?>
                                    </span>
                                </div>

                                <!-- ELIMINAR -->
                                <form method="POST" action="<?= \App\Config\App::baseUrl() ?>/carrito/remove">
                                    <input type="hidden" name="prenda_id" value="<?= $producto['id'] ?>">
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash3"></i> Eliminar
                                    </button>
                                </form>

                            </div>

                            <!-- PRECIO -->
                            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                <p class="fw-bold fs-5 mb-1">
                                    <?= number_format($producto['precio_asignado'], 2) ?> €
                                </p>
                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>
        </div>

        <!-- COLUMNA DERECHA -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 resumen-card">
                
                <?php
                $total = 0;
                foreach ($productos as $producto) {
                    $total += $producto['precio_asignado'];
                }
                ?>

                <h3 class="fs-4 fw-semibold mb-4">Resumen del pedido</h3>

                <div class="d-flex justify-content-between mb-3">
                    <span>Subtotal</span>
                    <span><?= number_format($total, 2) ?> €</span>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <span>Envío</span>
                    <span>Gratis</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mt-3 mb-4 total-box">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-4">
                        <?= number_format($total, 2) ?> €
                    </span>
                </div>

                <button class="btn btn-dark w-100 py-3 fw-semibold mb-3">
                    <i class="bi bi-bag-check"></i> Comprar ahora
                </button>

                <a href="<?= \App\Config\App::baseUrl() ?>/prendas/catalogo" 
                   class="btn btn-outline-secondary w-100 py-3 fw-semibold">
                    Seguir comprando
                </a>

            </div>
        </div>

    </div>

</div>
<br>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>