<?php
/** @var array $prendas */
?>

<div class="container-fluid mt-4">

    <div class="row g-3">

        <!-- Si no hay prendas, mostrar mensaje -->
        <?php if (empty($prendas)): ?>
            <p class="text-center">No hay prendas disponibles</p>
        <?php endif; ?>
        <!-- Si hay prendas, mostrarlas en tarjetas -->
        <?php foreach ($prendas as $prenda): ?>

            <?php
            if (
                !$prenda['tipo']
                || !$prenda['colegio']
                || !$prenda['precio_asignado']
                || $prenda['precio_asignado'] <= 0
            ) {
                continue;
            }

            // ID único para cada modal
            $modalId = 'modalPrenda_' . $prenda['id'];
            ?>
            <!-- Tarjeta de prenda -->
            <div class="col-md-3 mb-4">

                <div class="card card-prenda h-100 shadow-sm">

                    <?php if (!empty($prenda['imagen'])): ?>
                        <img src="/proyecto_TFG/TFG_BackAndFront/public<?= $prenda['imagen'] ?>"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">
                    <?php endif; ?>

                    <div class="card-body">

                        <h5 class="card-title">
                            <?= htmlspecialchars($prenda['tipo']) ?>
                        </h5>

                        <p class="info-colegio">
                            <strong>Colegio:</strong> <?= htmlspecialchars($prenda['colegio']) ?><br>

                            <?php
                            $badge = 'secondary';

                            if ($prenda['estado'] == 'excelente') {
                                $badge = 'success';
                            } elseif ($prenda['estado'] == 'bueno') {
                                $badge = 'warning';
                            } elseif ($prenda['estado'] == 'aceptable') {
                                $badge = 'danger';
                            }
                            ?>

                            <span class="badge bg-<?= $badge ?>">
                                <?= htmlspecialchars($prenda['estado']) ?>
                            </span>
                            
                        </p>

                    </div>

                    <div class="card-footer text-center">
                        <strong><?= number_format($prenda['precio_asignado'], 2, ',', '.') ?> €</strong>

                        <br>
                        
                        <div class="card-botones">

                            <form method="POST" action="<?= \App\Config\App::baseUrl() ?>/carrito/add" class="m-0">
                                <input type="hidden" name="prenda_id" value="<?= $prenda['id'] ?>">
                                <button type="submit" class="btn btn-add-carrito">
                                    Añadir al carrito
                                </button>
                            </form>

                            <button class="btn btn-ver-detalle"
                                    data-bs-toggle="modal"
                                    data-bs-target="#<?= $modalId ?>">
                                Ver detalle
                            </button>

                        </div>
                    </div>

                </div>

            </div>

            <!-- MODAL -->
            <div class="modal fade" id="<?= $modalId ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                <?= htmlspecialchars($prenda['tipo']) ?>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center">

                            <?php if (!empty($prenda['imagen'])): ?>
                                <img src="/proyecto_TFG/TFG_BackAndFront/public<?= $prenda['imagen'] ?>"
                                     style="max-width:100%; height:auto; margin-bottom:15px;">
                            <?php endif; ?>

                            <p><strong>Colegio:</strong> <?= htmlspecialchars($prenda['colegio']) ?></p>
                            <p><strong>Estado:</strong> <?= htmlspecialchars($prenda['estado']) ?></p>
                            <p><strong>Precio:</strong> <?= number_format($prenda['precio_asignado'], 2, ',', '.') ?> €</p>
                            <strong>Vendedor:</strong> <?= htmlspecialchars($prenda['vendedor']) ?><br>

                        </div>
                        
                        <div class="card-footer text-center">
                            <div class="card-botones">

                                <form method="POST" action="<?= \App\Config\App::baseUrl() ?>/carrito/add" class="m-0">
                                    <input type="hidden" name="prenda_id" value="<?= $prenda['id'] ?>">
                                    <button type="submit" class="btn btn-add-carrito">
                                        Añadir al carrito
                                    </button>
                                </form>

                                <button type="button" class="btn btn-ver-detalle" data-bs-dismiss="modal">
                                    Cerrar
                                </button>

                            </div>
                        </div>
                        <br>    
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

</div>