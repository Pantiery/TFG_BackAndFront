<?php require_once __DIR__ . '/../layout/header.php'; ?>

<?php
$detalle = $detalle ?? [];

$venta = $detalle['venta'] ?? [];
$prendas = $detalle['prendas'] ?? [];

$totalComisiones = $detalle['total_comisiones'] ?? 0;
$totalVendedor = $detalle['total_vendedor'] ?? 0;
?>

<main>

    <!-- HERO -->

    <section class="admin-hero">

        <div class="admin-contenedor">

            <h1>
                Detalle de venta #<?= $venta['id'] ?>
            </h1>

            <p>
                Consulta el desglose completo de la venta,
                incluyendo comprador, prendas, comisiones
                e importes de vendedores.
            </p>

        </div>

    </section>

    <!-- CONTENIDO -->

    <section class="admin-seccion">

        <div class="admin-contenedor-wide">

            <!-- DATOS GENERALES -->

            <div class="card shadow border-0 mb-4">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <h5 class="fw-bold mb-3">
                                Información de la venta
                            </h5>

                            <p>
                                <strong>Pedido:</strong>
                                #<?= $venta['id'] ?>
                            </p>

                            <p>
                                <strong>Comprador:</strong>
                                <?= htmlspecialchars($venta['comprador_nombre']) ?>
                                <?= htmlspecialchars($venta['comprador_apellido']) ?>
                            </p>

                            <p>
                                <strong>Fecha:</strong>
                                <?= date('d/m/Y', strtotime($venta['fecha'])) ?>
                            </p>

                        </div>

                        <div class="col-md-6 mb-3">

                            <h5 class="fw-bold mb-3">
                                Estado económico
                            </h5>

                            <p>
                                <strong>Total cliente:</strong>
                                <?= number_format($venta['total'], 2) ?> €
                            </p>

                            <p>
                                <strong>Total comisiones:</strong>
                                <span class="text-danger fw-bold">
                                    <?= number_format($totalComisiones, 2) ?> €
                                </span>
                            </p>

                            <p>
                                <strong>Neto vendedores:</strong>
                                <span class="text-success fw-bold">
                                    <?= number_format($totalVendedor, 2) ?> €
                                </span>
                            </p>

                            <p>
                                <strong>Estado pago:</strong>

                                <?php if ($venta['estado_pago'] === 'pagado'): ?>

                                    <span class="badge bg-success">
                                        Pagado
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-warning text-dark">
                                        Pendiente
                                    </span>

                                <?php endif; ?>

                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- TABLA PRENDAS -->

            <div class="card shadow border-0">

                <div class="card-body">

                    <h4 class="fw-bold mb-4">
                        Prendas incluidas
                    </h4>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-dark">

                                <tr>
                                    <th>Imagen</th>
                                    <th>Tipo</th>
                                    <th>Colegio</th>
                                    <th>Vendedor</th>
                                    <th>Precio</th>
                                    <th>Comisión</th>
                                    <th>Neto vendedor</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($prendas as $prenda): ?>

                                    <tr>

                                    <tr>

                                        <td>

                                            <img src="<?= \App\Config\App::baseUrl() . $prenda['imagen'] ?>"
                                                alt="Prenda"
                                                class="rounded shadow-sm"
                                                style="width: 80px; height: 80px; object-fit: cover;">

                                        </td>

                                        <td>
                                            <?= htmlspecialchars($prenda['tipo_prenda']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($prenda['colegio']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($prenda['vendedor_nombre']) ?>
                                        </td>

                                        <td class="fw-bold">

                                            <?= number_format(
                                                $prenda['importe_vendedor'] + $prenda['comision'],
                                                2
                                            ) ?> €

                                        </td>

                                        <td class="text-danger fw-bold">

                                            <?= number_format($prenda['comision'], 2) ?> €

                                        </td>

                                        <td class="text-success fw-bold">

                                            <?= number_format($prenda['importe_vendedor'], 2) ?> €

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                    <!-- BOTÓN VOLVER -->

                    <div class="mt-4">

                        <a href="<?= \App\Config\App::url('/admin/ventas') ?>"
                            class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left"></i>
                            Volver a ventas

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>