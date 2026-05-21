<?php require_once __DIR__ . '/../layout/header.php'; ?>

<?php
$ventas = $ventas ?? [];
$totalVentas = $totalVentas ?? 0;
$totalComisiones = $totalComisiones ?? 0;
$totalPedidos = $totalPedidos ?? 0;
$totalPrendas = $totalPrendas ?? 0;
?>

<?php
$hayFiltroComprador = !empty($_GET['comprador']);
$hayFiltroVendedor = !empty($_GET['vendedor']);
?>

<main>

    <!-- HERO -->

    <section class="admin-hero">

        <div class="admin-contenedor">

            <h1>
                Gestión de ventas
            </h1>

            <p>
                Supervisa pedidos, pagos pendientes, comisiones y
                ganancias de los vendedores registrados.
            </p>

        </div>

    </section>

    <!-- CONTENIDO -->

    <section class="admin-seccion">

        <div class="admin-contenedor-wide">

            <!-- FILTROS -->

            <div class="card shadow border-0 mb-5">

                <div class="card-body">

                    <form method="GET"
                        action="<?= \App\Config\App::url('/admin/ventas') ?>">

                        <div class="row g-3 align-items-end justify-content-center">

                            <!-- VENDEDOR -->

                            <div class="col-lg-3 col-md-6">

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

                            <div class="col-lg-2 col-md-6">

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

                            <div class="col-lg-2 col-md-6">

                                <label class="form-label fw-bold">
                                    Fecha desde
                                </label>

                                <input type="date"
                                    name="desde"
                                    class="form-control"
                                    value="<?= $_GET['desde'] ?? '' ?>">

                            </div>

                            <!-- FECHA HASTA -->

                            <div class="col-lg-2 col-md-6">

                                <label class="form-label fw-bold">
                                    Fecha hasta
                                </label>

                                <input type="date"
                                    name="hasta"
                                    class="form-control"
                                    value="<?= $_GET['hasta'] ?? '' ?>">

                            </div>

                            <!-- BOTONES -->

                            <div class="col-lg-3 col-md-12">

                                <div class="d-flex gap-2">

                                    <button class="btn btn-primary flex-fill">

                                        <i class="bi bi-funnel-fill"></i>
                                        Filtrar

                                    </button>

                                    <a href="<?= \App\Config\App::url('/admin/ventas') ?>"
                                        class="btn btn-outline-secondary flex-fill d-flex align-items-center justify-content-center">

                                        <i class="bi bi-x-circle me-1"></i>
                                        Limpiar

                                    </a>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <!-- TABLA -->

            <div class="table-responsive admin-tabla">

                <table class="table table-hover align-middle mb-0">


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

                                <td>
                                    <span class="fw-bold text-primary">
                                        #<?= $venta['venta_id'] ?>
                                    </span>
                                </td>

                                <td>
                                    <?= htmlspecialchars($venta['comprador_nombre']) ?>
                                </td>

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

                                <td class="fw-bold fs-5">
                                    <?= number_format($venta['total'], 2) ?> €
                                </td>

                                <td class="text-danger fw-bold">

                                    <?php
                                    $comisionTotal = array_sum(
                                        array_column($venta['prendas'], 'comision')
                                    );
                                    ?>

                                    <?= number_format($comisionTotal, 2) ?> €

                                </td>

                                <td class="text-success fw-bold">

                                    <?= number_format(
                                        $venta['total'] - $comisionTotal,
                                        2
                                    ) ?> €

                                </td>

                                <td id="estado-venta-<?= $venta['venta_id'] ?>">

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

                                <td>

                                    <a href="<?= \App\Config\App::url('/admin/ventas/detalle?id=' . $venta['venta_id']) ?>"
                                        class="btn btn-primary btn-sm mb-2">

                                        <i class="bi bi-eye"></i>
                                        Ver detalle

                                    </a>

                                    <br>

                                    <?php if ($venta['estado_pago'] === 'pendiente'): ?>

                                        <form
                                            method="POST"
                                            action="<?= \App\Config\App::url('/admin/ventas/pagar') ?>"
                                            class="form-pagar-venta">

                                            <input
                                                type="hidden"
                                                name="venta_id"
                                                value="<?= $venta['venta_id'] ?>">

                                            <button
                                                type="submit"
                                                class="btn btn-success btn-sm">

                                                <i class="bi bi-check-circle"></i>
                                                Pagar pedido

                                            </button>

                                        </form>

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

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>