<?php require __DIR__ . '/../layout/header.php'; ?>

<main>

    <section class="admin-hero">

        <div class="admin-contenedor">

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

            <!-- FILTRO -->

            <div class="card shadow border-0 mb-5">

                <div class="card-body">

                    <form method="GET"
                        action="<?= \App\Config\App::url('/admin/prendas-pendientes') ?>">

                        <div class="row g-3 align-items-end justify-content-center">

                            <div class="col-lg-6 col-md-8">

                                <label class="form-label fw-bold">

                                    Buscar prenda

                                </label>

                                <input type="text"
                                    name="buscar"
                                    class="form-control"
                                    placeholder="Usuario o email"
                                    value="<?= $_GET['buscar'] ?? '' ?>">

                            </div>

                            <div class="col-lg-3 col-md-4">

                                <div class="d-flex gap-2">

                                    <button class="btn btn-primary flex-fill">

                                        <i class="bi bi-search"></i>

                                        Buscar

                                    </button>

                                    <a href="<?= \App\Config\App::url('/admin/prendas-pendientes') ?>"
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