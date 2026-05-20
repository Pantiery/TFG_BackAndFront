<?php require_once __DIR__ . '/../layout/header.php'; ?>

<?php
$totalVentas = $totalVentas ?? 0;
$totalComisiones = $totalComisiones ?? 0;
$totalPedidos = $totalPedidos ?? 0;
$totalPrendas = $totalPrendas ?? 0;
$netoTotal = $netoTotal ?? 0;
$co2Ahorrado = $co2Ahorrado ?? 0;
$aguaAhorrada = $aguaAhorrada ?? 0;
$ahorroFamilias = $ahorroFamilias ?? 0;
?>

<main>

    <!-- HERO -->

    <section class="admin-hero">

        <div class="admin-contenedor-wide">

            <h1>
                Estadísticas del sistema
            </h1>

            <p>
                Consulta las métricas globales de la plataforma,
                controla ingresos, ventas y actividad general
                del marketplace.
            </p>

        </div>

    </section>

    <!-- CONTENIDO -->

    <section class="admin-seccion">

        <div class="admin-contenedor-wide">

            <!-- KPIs -->

            <div class="row g-4 mb-5">

                <!-- TOTAL VENDIDO -->

                <div class="col-xl-3 col-md-6">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body d-flex align-items-center">

                            <div class="me-3 fs-1 text-primary">
                                <i class="bi bi-cart-check-fill"></i>
                            </div>

                            <div>

                                <h6 class="text-muted mb-1">
                                    Total vendido
                                </h6>

                                <h2 class="fw-bold mb-0">
                                    <?= number_format($totalVentas, 2) ?> €
                                </h2>

                                <small class="text-muted">
                                    Importe generado
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- COMISIONES -->

                <div class="col-xl-3 col-md-6">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body d-flex align-items-center">

                            <div class="me-3 fs-1 text-success">
                                <i class="bi bi-cash-stack"></i>
                            </div>

                            <div>

                                <h6 class="text-muted mb-1">
                                    Comisiones
                                </h6>

                                <h2 class="fw-bold text-success mb-0">
                                    <?= number_format($totalComisiones, 2) ?> €
                                </h2>

                                <small class="text-muted">
                                    Beneficio plataforma
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- PEDIDOS -->

                <div class="col-xl-3 col-md-6">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body d-flex align-items-center">

                            <div class="me-3 fs-1 text-warning">
                                <i class="bi bi-bag-check-fill"></i>
                            </div>

                            <div>

                                <h6 class="text-muted mb-1">
                                    Pedidos
                                </h6>

                                <h2 class="fw-bold mb-0">
                                    <?= $totalPedidos ?>
                                </h2>

                                <small class="text-muted">
                                    Pedidos registrados
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- PRENDAS -->

                <div class="col-xl-3 col-md-6">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body d-flex align-items-center">

                            <div class="me-3 fs-1 text-danger">
                                <i class="bi bi-box-seam-fill"></i>
                            </div>

                            <div>

                                <h6 class="text-muted mb-1">
                                    Prendas vendidas
                                </h6>

                                <h2 class="fw-bold mb-0">
                                    <?= $totalPrendas ?>
                                </h2>

                                <small class="text-muted">
                                    Unidades vendidas
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- SEGUNDA FILA -->

            <div class="row g-4">

                <!-- NETO VENDEDORES -->

                <div class="col-lg-6">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body">

                            <h4 class="mb-4">
                                Pagos a vendedores
                            </h4>

                            <h1 class="fw-bold text-success">
                                <?= number_format($netoTotal, 2) ?> €
                            </h1>

                            <p class="text-muted mb-0">
                                Importe total destinado a vendedores
                                tras descontar las comisiones.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- RESUMEN -->

                <div class="col-lg-6">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body">

                            <h4 class="mb-4">
                                Resumen del marketplace
                            </h4>

                            <ul class="list-group list-group-flush">

                                <li class="list-group-item d-flex justify-content-between">

                                    <span>Total vendido</span>

                                    <strong>
                                        <?= number_format($totalVentas, 2) ?> €
                                    </strong>

                                </li>

                                <li class="list-group-item d-flex justify-content-between">

                                    <span>Beneficio plataforma</span>

                                    <strong class="text-success">
                                        <?= number_format($totalComisiones, 2) ?> €
                                    </strong>

                                </li>

                                <li class="list-group-item d-flex justify-content-between">

                                    <span>Pedidos realizados</span>

                                    <strong>
                                        <?= $totalPedidos ?>
                                    </strong>

                                </li>

                                <li class="list-group-item d-flex justify-content-between">

                                    <span>Prendas vendidas</span>

                                    <strong>
                                        <?= $totalPrendas ?>
                                    </strong>

                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

            <!-- FILA SOSTENIBILIDAD -->

            <div class="row g-4 mt-1">

                <!-- CO2 -->

                <div class="col-lg-4">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body text-center">

                            <div class="fs-1 text-success mb-3">
                                <i class="bi bi-globe-europe-africa"></i>
                            </div>

                            <h5>
                                CO₂ ahorrado
                            </h5>

                            <h2 class="fw-bold text-success">
                                <?= number_format($co2Ahorrado, 0) ?> kg
                            </h2>

                            <p class="text-muted mb-0">
                                Emisiones evitadas gracias a la reutilización
                                de uniformes escolares.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- AGUA -->

                <div class="col-lg-4">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body text-center">

                            <div class="fs-1 text-primary mb-3">
                                <i class="bi bi-droplet-fill"></i>
                            </div>

                            <h5>
                                Agua ahorrada
                            </h5>

                            <h2 class="fw-bold text-primary">
                                <?= number_format($aguaAhorrada, 0) ?> L
                            </h2>

                            <p class="text-muted mb-0">
                                Consumo de agua evitado mediante reutilización
                                textil.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- AHORRO FAMILIAS -->

                <div class="col-lg-4">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body text-center">

                            <div class="fs-1 text-warning mb-3">
                                <i class="bi bi-recycle"></i>
                            </div>

                            <h5>
                                Ahorro familias
                            </h5>

                            <h2 class="fw-bold text-warning">
                                <?= number_format($ahorroFamilias, 2) ?> €
                            </h2>

                            <p class="text-muted mb-0">
                                Estimación de ahorro económico generado
                                para las familias.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>