<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container">

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
                    <span class="badge text-bg-dark rounded-pill px-3 py-2">1 producto</span>
                </div>

                <!-- PRODUCTO 1 PRUEBA -->
                <div class="row align-items-center carrito-item py-4">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <img src="/proyecto_TFG/TFG_BackAndFront/public/uploads/1776410934_sudadera-JulioVerne-L-excelente.jpg" alt="Sudadera Julio Verne" class="img-fluid rounded-4 w-100 producto-img">
                    </div>

                    <div class="col-md-6">
                        <h4 class="fs-5 fw-bold mb-2">Sudadera Julio Verne</h4>
                        <p class="text-muted mb-2">Sudadera cómoda de algodón.</p>

                        <div class="d-flex flex-wrap gap-3 small text-secondary mb-3">
                            <span><strong>Talla:</strong> M</span>
                            <span><strong>Color:</strong> Beige</span>
                            <span><strong>Estado:</strong> Excelente</span>
                        </div>

                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <button class="btn btn-outline-danger">
                                <i class="bi bi-trash3"></i> Eliminar
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                        <p class="fw-bold fs-5 mb-1">22,00 €</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- COLUMNA DERECHA -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 resumen-card">
                <h3 class="fs-4 fw-semibold mb-4">Resumen del pedido</h3>

                <div class="d-flex justify-content-between mb-3">
                    <span>Subtotal</span>
                    <span>22,00 €</span>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <span>Envío</span>
                    <span>Gratis</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mt-3 mb-4 total-box">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-4">22,00 €</span>
                </div>

                <button class="btn btn-dark w-100 py-3 fw-semibold mb-3">
                    <i class="bi bi-bag-check"></i> Comprar ahora
                </button>

                <button class="btn btn-outline-secondary w-100 py-3 fw-semibold" href="/proyecto_TFG/TFG_BackAndFront/app/views/prendas/catalogo.php">
                    Seguir comprando
                </button>

                <div class="mt-4 small text-muted">
                    <p class="mb-2"><i class="bi bi-shield-check"></i> Pago seguro garantizado</p>
                    <p class="mb-0"><i class="bi bi-truck"></i> Envío rápido o recogida en centro asignado</p>
                </div>
            </div>
        </div>
    </div>

    <!-- RECOMENDACIONES -->
    <section class="mt-5">
        <h3 class="fw-bold mb-4">También te puede gustar</h3>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden producto-sugerido">
                    <img src="/proyecto_TFG/TFG_BackAndFront/public/uploads/1776409986_chandal-l-jpii-bueno.webp" class="card-img-top" alt="Chándal">
                    <div class="card-body">
                        <h4 class="fs-6 fw-bold">Chándal Juan Pablo II</h4>
                        <p class="text-muted small mb-2">Perfecta para clase de deporte.</p>
                        <span><strong>Talla:</strong> L</span><br>
                        <span><strong>Estado:</strong> Bueno</span>
                        <p class="fw-bold mb-0">20,00 €</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden producto-sugerido">
                    <img src="/proyecto_TFG/TFG_BackAndFront/public/uploads/1776410361_pantalonLargo-ggm-12-bueno.jpg" class="card-img-top" alt="Pantalón largo">
                    <div class="card-body">
                        <h4 class="fs-6 fw-bold">Pantalón largo Gabriel García Márquez</h4>
                        <p class="text-muted small mb-2">Tejido suave y muy cómodo.</p>
                        <span><strong>Talla:</strong> 12</span><br>
                        <span><strong>Estado:</strong> Aceptable</span>
                        <p class="fw-bold mb-0">12,00 €</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden producto-sugerido">
                    <img src="/proyecto_TFG/TFG_BackAndFront/public/uploads/1776410580_polo-XS-JulioVerne-excelente.avif" class="card-img-top" alt="Polo">
                    <div class="card-body">
                        <h4 class="fs-6 fw-bold">Polo Julio Verne</h4>
                        <p class="text-muted small mb-2">Diseño limpio y versátil.</p>
                        <span><strong>Talla:</strong> XS</span><br>
                        <span><strong>Estado:</strong> Excelente</span>
                        <p class="fw-bold mb-0">15,00 €</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden producto-sugerido">
                    <img src="/proyecto_TFG/TFG_BackAndFront/public/uploads/1776411091_pantCort-MadridSur-s-aceptable.jpg" class="card-img-top" alt="Pantalón corto">
                    <div class="card-body">
                        <h4 class="fs-6 fw-bold">Pantalón corto Colegio Madrid Sur</h4>
                        <p class="text-muted small mb-2">Para los días más calurosos.</p>
                        <span><strong>Talla:</strong> S</span><br>
                        <span><strong>Estado:</strong> Aceptable</span>
                        <p class="fw-bold mb-0">10,00 €</p>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </section>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>