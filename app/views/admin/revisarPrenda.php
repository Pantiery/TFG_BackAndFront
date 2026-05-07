<?php

/** @var array $prenda */

require __DIR__ . '/../layout/header.php';
?>

<main>

    <section class="admin-hero">

        <div class="admin-contenedor">

            <span class="home-etiqueta">
                Panel de administración
            </span>

            <h1>
                Revisar prenda
            </h1>

            <p>
                Verifica la información enviada por el usuario y decide
                si la prenda cumple los requisitos para publicarse.
            </p>

        </div>

    </section>

    <section class="admin-seccion">

        <div class="admin-contenedor">

            <a href="<?= \App\Config\App::url('/admin/prendas-pendientes') ?>"
                class="btn btn-light admin-btn-volver">

                ← Volver

            </a>

            <article class="admin-card admin-detalle">

                <div class="admin-detalle-img">

                    <img
                        src="<?= \App\Config\App::url($prenda['imagen']) ?>"
                        alt="Prenda">

                </div>

                <div class="admin-card-body">

                    <h3>
                        <?= htmlspecialchars($prenda['tipo']) ?>
                    </h3>

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

                    <p class="admin-info">
                        <strong>Colegio:</strong>
                        <?= htmlspecialchars($prenda['colegio']) ?>
                    </p>

                    <p class="admin-info">
                        <strong>Talla:</strong>
                        <?= htmlspecialchars($prenda['talla']) ?>
                    </p>

                    <p class="admin-info">
                        <strong>Género:</strong>
                        <?= htmlspecialchars($prenda['genero']) ?>
                    </p>

                    <p class="admin-info">
                        <strong>Vendedor:</strong>
                        <?= htmlspecialchars($prenda['vendedor'] . ' ' . $prenda['apellido1']) ?>
                    </p>

                    <p class="admin-info">
                        <strong>Precio:</strong>
                        <?= number_format($prenda['precio_asignado'], 2, ',', '.') ?> €
                    </p>

                    <div class="admin-actions">

                        <a href="<?= \App\Config\App::url('/admin/prenda/aprobar?id=' . $prenda['id']) ?>"
                            class="btn btn-success">

                            Aprobar

                        </a>

                        <a href="<?= \App\Config\App::url('/admin/prenda/rechazar?id=' . $prenda['id']) ?>"
                            class="btn btn-danger">

                            Rechazar

                        </a>

                    </div>

                </div>

            </article>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>