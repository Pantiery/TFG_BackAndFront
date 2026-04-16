<div class="container mt-4">

    <div class="row">

        <?php if (empty($prendas)): ?>
            <p class="text-center">No hay prendas disponibles</p>
        <?php endif; ?>

        <?php foreach ($prendas as $prenda): ?>

            <?php 
            // CONTROL DE DATOS
            if (
                !$prenda['tipo'] ||
                !$prenda['colegio'] ||
                !$prenda['precio_asignado'] ||
                $prenda['precio_asignado'] <= 0
            ) continue;
            ?>

            <div class="col-md-4 mb-4">

                <div class="card h-100 shadow-sm">

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
                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>