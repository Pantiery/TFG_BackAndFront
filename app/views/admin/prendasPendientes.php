<?php require __DIR__ . '/../layout/header.php'; ?>

<main>

    <section class="admin-hero">

        <div class="admin-contenedor">

            <span class="home-etiqueta">
                Panel de administración
            </span>

            <h1>
                Gestión de prendas
            </h1>

            <p>
                Revisa las solicitudes pendientes enviadas por los usuarios,
                valida el estado de las prendas y decide si pueden publicarse
                en el catálogo.
            </p>

        </div>

    </section>

    <section class="admin-seccion">

        <div class="admin-contenedor-wide">

            <?php require __DIR__ . '/../layout/messages.php'; ?>

            <?php if (empty($pendientes)): ?>

                <div class="admin-vacio">

                    No hay prendas pendientes de revisión.

                </div>

            <?php else: ?>

                <div class="admin-grid">

                    <?php foreach ($pendientes as $prenda): ?>

                        <article class="admin-card">

                            <img
                                src="<?= \App\Config\App::url($prenda['imagen']) ?>"
                                alt="Prenda">

                            <div class="admin-card-body">

                                <h3>
                                    <?= htmlspecialchars($prenda['tipo']) ?>
                                </h3>

                                <p class="admin-info">
                                    <strong>Colegio:</strong>
                                    <?= htmlspecialchars($prenda['colegio']) ?>
                                </p>

                                <p class="admin-info">
                                    <strong>Vendedor:</strong>
                                    <?= htmlspecialchars($prenda['vendedor'] . ' ' . $prenda['apellido1']) ?>
                                </p>

                                <p class="admin-info">

                                    <strong>Estado:</strong>

                                    <?php if ($prenda['estado'] === 'excelente'): ?>

                                        <span class="admin-badge badge-excelente">
                                            Excelente
                                        </span>

                                    <?php elseif ($prenda['estado'] === 'bueno'): ?>

                                        <span class="admin-badge badge-bueno">
                                            Bueno
                                        </span>

                                    <?php else: ?>

                                        <span class="admin-badge badge-aceptable">
                                            Aceptable
                                        </span>

                                    <?php endif; ?>

                                </p>

                                <div class="admin-actions">

                                    <a href="<?= \App\Config\App::url('/admin/prenda/revisar?id=' . $prenda['id']) ?>"
                                        class="btn btn-primary">

                                        Revisar

                                    </a>

                                </div>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>