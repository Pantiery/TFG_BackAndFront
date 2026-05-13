<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main>

    <section class="admin-hero">

        <div class="admin-contenedor">

            <span class="home-etiqueta">
                Panel de administración
            </span>

            <h1>
                Gestión de usuarios
            </h1>

            <p>
                Administra los usuarios registrados en la plataforma,
                controla accesos y bloquea cuentas cuando sea necesario.
            </p>

        </div>

    </section>

    <section class="admin-seccion">

        <div class="admin-contenedor-wide">

            <?php require __DIR__ . '/../layout/messages.php'; ?>

            <?php if (empty($usuarios)): ?>

                <div class="admin-vacio">

                    No hay usuarios registrados.

                </div>

            <?php else: ?>

                <div class="admin-grid">

                    <?php foreach ($usuarios as $user): ?>

                        <article class="admin-card">

                            <div class="admin-card-body">

                                <h3>
                                    <?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido1']) ?>
                                </h3>

                                <p class="admin-info">
                                    <strong>Email:</strong>
                                    <?= htmlspecialchars($user['email']) ?>
                                </p>

                                <p class="admin-info">
                                    <strong>Rol:</strong>
                                    <?= htmlspecialchars($user['rol']) ?>
                                </p>

                                <p class="admin-info">

                                    <strong>Estado:</strong>

                                    <?php if ($user['activo'] == 1): ?>

                                        <span class="admin-badge badge-excelente">
                                            Activo
                                        </span>

                                    <?php else: ?>

                                        <span class="admin-badge badge-aceptable">
                                            Bloqueado
                                        </span>

                                    <?php endif; ?>

                                </p>

                                <div class="admin-actions">

                                    <?php if ($user['activo'] == 1): ?>

                                        <a href="<?= \App\Config\App::url('/admin/usuarios/bloquear?id=' . $user['id']) ?>"
                                            class="btn btn-danger">

                                            Bloquear

                                        </a>

                                    <?php else: ?>

                                        <a href="<?= \App\Config\App::url('/admin/usuarios/activar?id=' . $user['id']) ?>"
                                            class="btn btn-success">

                                            Activar

                                        </a>

                                    <?php endif; ?>

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