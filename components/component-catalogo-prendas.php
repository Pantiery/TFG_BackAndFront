<div class="container-fluid mt-4">

    <div class="row">

        <?php if (empty($prendas)): ?>
            <p class="text-center">No hay prendas disponibles</p>
        <?php endif; ?>

        <?php foreach ($prendas as $prenda): ?>

            <?php
            if (
                !$prenda['tipo'] ||
                !$prenda['colegio'] ||
                !$prenda['precio_asignado'] ||
                $prenda['precio_asignado'] <= 0
            ) continue;

            // ID único para cada modal
            $modalId = "modalPrenda_" . $prenda['id'];
            ?>

            <div class="col-md-3 mb-4">

                <div class="card h-100 shadow-sm">

                    <?php if (!empty($prenda['imagen'])): ?>
                        <img src="/proyecto_TFG/TFG_BackAndFront/public<?= $prenda['imagen'] ?>"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">
                    <?php endif; ?>

                    <div class="card-body">

                        <h5 class="card-title">
                            <?= htmlspecialchars($prenda['tipo']) ?>
                        </h5>

                        <p class="card-text">
                            <strong>Colegio:</strong> <?= htmlspecialchars($prenda['colegio']) ?><br>

                            <?php
                            $badge = 'secondary';

                            if ($prenda['estado'] == 'excelente')
                                $badge = 'success';
                            elseif ($prenda['estado'] == 'bueno')
                                $badge = 'warning';
                            elseif ($prenda['estado'] == 'aceptable')
                                $badge = 'danger';
                            ?>

                            <span class="badge bg-<?= $badge ?>">
                                <?= htmlspecialchars($prenda['estado']) ?>
                            </span>
                            
                        </p>

                    </div>

                    <div class="card-footer text-center">
                        <strong><?= $prenda['precio_asignado'] ?> €</strong>

                        <br>
                        
                        <form method="POST" action="<?= \App\Config\App::baseUrl() ?>/carrito/add">
                            <input type="hidden" name="prenda_id" value="<?= $prenda['id'] ?>">
                            <button class="btn btn-sm btn-primary mt-2">
                                Añadir al carrito
                            </button>
                        </form>

                        <!-- BOTÓN MODAL -->
                        <button class="btn btn-sm btn-primary mt-2"
                                data-bs-toggle="modal"
                                data-bs-target="#<?= $modalId ?>">
                            Ver detalle
                        </button>
                        <button class="btn btn-sm btn-primary mt-2" href="">
                            Comprar
                        </button>
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
                            <p><strong>Precio:</strong> <?= $prenda['precio_asignado'] ?> €</p>
                            <strong>Vendedor:</strong> <?= htmlspecialchars($prenda['vendedor']) ?><br>

                        </div>
                        
                        <div class="card-footer text-center">
                            
                            <form method="POST" action="<?= \App\Config\App::baseUrl() ?>/carrito/add">
                                <input type="hidden" name="prenda_id" value="<?= $prenda['id'] ?>">
                                <button class="btn btn-sm btn-primary mt-2">
                                    Añadir al carrito
                                </button>
                            </form>
                            
                            <button class="btn btn-sm btn-primary mt-2" href="">
                                Comprar
                            </button>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

</div>