<?php require_once __DIR__ . '/../layout/header.php'; ?>

<?php
$ventas = $ventas ?? [];
$totalVentas = $totalVentas ?? 0;
$totalComisiones = $totalComisiones ?? 0;
$totalPedidos = $totalPedidos ?? 0;
$totalPrendas = $totalPrendas ?? 0;
?>

<main class="container-fluid px-5 py-5 admin-ventas-page">

    <h1 class="mb-4">Gestión de Ventas</h1>

    <!-- Estadísticas -->

    <div class="row g-4 mb-5">

        <!-- TOTAL VENDIDO -->

        <div class="col-lg-3 col-md-6">

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
                            Importe total generado
                        </small>

                    </div>

                </div>

            </div>

        </div>

        <!-- COMISIONES -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="me-3 fs-1 text-success">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div>

                        <h6 class="text-muted mb-1">
                            Total comisiones
                        </h6>

                        <h2 class="fw-bold text-success mb-0">
                            <?= number_format($totalComisiones, 2) ?> €
                        </h2>

                        <small class="text-muted">
                            Comisión plataforma
                        </small>

                    </div>

                </div>

            </div>

        </div>

        <!-- Nº VENTAS -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="me-3 fs-1 text-warning">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>

                    <div>

                        <h6 class="text-muted mb-1">
                            Nº ventas
                        </h6>

                        <h2 class="fw-bold mb-0">
                            <?= $totalPedidos ?>
                        </h2>

                        <small class="text-muted">
                            Ventas registradas
                        </small>

                    </div>

                </div>

            </div>

        </div>

        <!-- PRENDAS -->

        <div class="col-lg-3 col-md-6">

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

    <!-- FILTROS -->

    <form method="GET"
        action="<?= \App\Config\App::url('/admin/ventas') ?>">

        <div class="card shadow border-0 mb-4">

            <div class="card-body">

                <div class="row g-3 align-items-end">

                    <!-- COMPRADOR -->

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-bold">
                            Comprador
                        </label>

                        <input type="text"
                            name="comprador"
                            class="form-control"
                            placeholder="Nombre comprador"
                            value="<?= $_GET['comprador'] ?? '' ?>">

                    </div>

                    <!-- VENDEDOR -->

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-bold">
                            Vendedor
                        </label>

                        <input type="text"
                            name="vendedor"
                            class="form-control"
                            placeholder="Nombre vendedor"
                            value="<?= $_GET['vendedor'] ?? '' ?>">

                    </div>

                    <!-- ESTADO -->

                    <div class="col-lg-2 col-md-4">

                        <label class="form-label fw-bold">
                            Estado pago
                        </label>

                        <select name="estado" class="form-select">

                            <option value="">
                                Todos
                            </option>

                            <option value="pendiente"
                                <?= ($_GET['estado'] ?? '') === 'pendiente' ? 'selected' : '' ?>>

                                Pendiente

                            </option>

                            <option value="pagado"
                                <?= ($_GET['estado'] ?? '') === 'pagado' ? 'selected' : '' ?>>

                                Pagado

                            </option>

                        </select>

                    </div>

                    <!-- FECHA DESDE -->

                    <div class="col-lg-2 col-md-4">

                        <label class="form-label fw-bold">
                            Fecha desde
                        </label>

                        <input type="date"
                            name="desde"
                            class="form-control"
                            value="<?= $_GET['desde'] ?? '' ?>">

                    </div>

                    <!-- FECHA HASTA -->

                    <div class="col-lg-2 col-md-4">

                        <label class="form-label fw-bold">
                            Fecha hasta
                        </label>

                        <input type="date"
                            name="hasta"
                            class="form-control"
                            value="<?= $_GET['hasta'] ?? '' ?>">

                    </div>

                    <!-- BOTÓN FILTRAR -->

                    <div class="col-lg-1 col-md-6 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-funnel-fill"></i>
                            Filtrar

                        </button>

                    </div>

                    <!-- BOTÓN LIMPIAR -->

                    <div class="col-lg-1 col-md-6 d-grid">

                        <a href="<?= \App\Config\App::url('/admin/ventas') ?>"
                            class="btn btn-outline-secondary d-flex align-items-center justify-content-center">

                            <i class="bi bi-x-circle me-1"></i>
                            Limpiar

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <!-- Tabla ventas -->

    <div class="table-responsive">

        <table class="table table-hover align-middle shadow-sm">

            <thead class="table-dark">

                <tr>
                    <th>Pedido</th>
                    <th>Comprador</th>
                    <th>Detalle pedido</th>
                    <th>Total cliente</th>
                    <th>Comisión</th>
                    <th>Neto vendedores</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($ventas as $venta): ?>

                    <tr>

                        <!-- ID bonito -->

                        <td>
                            <span class="fw-bold text-primary">
                                #<?= $venta['venta_id'] ?>
                            </span>
                        </td>

                        <td>
                            <?= htmlspecialchars($venta['comprador_nombre']) ?>
                        </td>

                        <!-- DETALLE PEDIDO -->

                        <td>

                            <div class="d-flex flex-column gap-2">

                                <?php foreach ($venta['prendas'] as $prenda): ?>

                                    <div class="border rounded p-2 bg-light text-start">

                                        <div class="d-flex justify-content-between align-items-center">

                                            <div>

                                                <div class="fw-bold">
                                                    <?= htmlspecialchars($prenda['tipo_prenda']) ?>
                                                </div>

                                                <small class="text-muted">
                                                    <?= htmlspecialchars($prenda['colegio']) ?>
                                                </small>

                                            </div>

                                            <div class="text-end">

                                                <div class="fw-bold">
                                                    <?= number_format(
                                                        $prenda['importe_vendedor'] + $prenda['comision'],
                                                        2
                                                    ) ?> €
                                                </div>

                                                <small class="text-success">
                                                    Neto:
                                                    <?= number_format($prenda['importe_vendedor'], 2) ?> €
                                                </small>

                                            </div>

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        </td>

                        <!-- TOTAL CLIENTE -->

                        <td class="fw-bold fs-5">
                            <?= number_format($venta['total'], 2) ?> €
                        </td>

                        <!-- COMISIÓN -->

                        <td class="text-danger fw-bold">

                            <?php
                            $comisionTotal = array_sum(
                                array_column($venta['prendas'], 'comision')
                            );
                            ?>

                            <?= number_format($comisionTotal, 2) ?> €

                        </td>

                        <!-- NETO VENDEDORES -->

                        <td class="text-success fw-bold">

                            <?= number_format(
                                $venta['total'] - $comisionTotal,
                                2
                            ) ?> €

                        </td>

                        <!-- BADGE -->

                        <td>

                            <?php if ($venta['estado_pago'] === 'pagado'): ?>

                                <span class="badge bg-success px-3 py-2">
                                    Pagado
                                </span>

                            <?php else: ?>

                                <span class="badge bg-warning text-dark px-3 py-2">
                                    Pendiente
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>
                            <?= date('d/m/Y', strtotime($venta['fecha'])) ?>
                        </td>

                        <!-- BOTÓN -->

                        <td>

                            <?php if ($venta['estado_pago'] === 'pendiente'): ?>

                                <a href="<?= \App\Config\App::url('/admin/ventas/pagar?id=' . $venta['venta_id']) ?>"
                                    class="btn btn-success btn-sm">

                                    <i class="bi bi-check-circle"></i>
                                    Pagar pedido

                                </a>

                            <?php else: ?>

                                <span class="text-success fw-bold">
                                    ✔ Pagada
                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>