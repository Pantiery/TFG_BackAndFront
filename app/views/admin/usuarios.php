<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main>

    <section class="admin-hero">

        <div class="admin-contenedor">

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

            <!-- FILTRO -->

            <div class="card shadow border-0 mb-5">

                <div class="card-body">

                    <form method="GET"
                        action="<?= \App\Config\App::url('/admin/usuarios') ?>">

                        <div class="row g-3 align-items-end justify-content-center">

                            <div class="col-lg-6 col-md-8">

                                <label class="form-label fw-bold">

                                    Buscar usuario

                                </label>

                                <input type="text"
                                    name="buscar"
                                    class="form-control"
                                    placeholder="Nombre o email"
                                    value="<?= $_GET['buscar'] ?? '' ?>">

                            </div>

                            <div class="col-lg-3 col-md-4">

                                <div class="d-flex gap-2">

                                    <button class="btn btn-primary flex-fill">

                                        <i class="bi bi-search"></i>

                                        Buscar

                                    </button>

                                    <a href="<?= \App\Config\App::url('/admin/usuarios') ?>"
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

            <?php if (empty($usuarios)): ?>

                <div class="admin-vacio">

                    No hay usuarios registrados.

                </div>

            <?php else: ?>

                <div class="table-responsive admin-tabla">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-dark">

                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($usuarios as $user): ?>

                                <tr>

                                    <td>

                                        <span class="fw-bold text-primary">

                                            #<?= $user['id'] ?>

                                        </span>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido1']) ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($user['email']) ?>

                                    </td>

                                    <td>

                                        <?php if ($user['rol'] === 'admin'): ?>

                                            <span class="badge bg-dark px-3 py-2">

                                                Admin

                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-primary px-3 py-2">

                                                Usuario

                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?php if ($user['activo'] == 1): ?>

                                            <span class="badge bg-success px-3 py-2">

                                                Activo

                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-danger px-3 py-2">

                                                Bloqueado

                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?php if ($user['activo'] == 1): ?>

                                            <a href="<?= \App\Config\App::url('/admin/usuarios/bloquear?id=' . $user['id']) ?>"
                                                class="btn btn-danger btn-sm">

                                                <i class="bi bi-lock-fill"></i>

                                                Bloquear

                                            </a>

                                        <?php else: ?>

                                            <a href="<?= \App\Config\App::url('/admin/usuarios/activar?id=' . $user['id']) ?>"
                                                class="btn btn-success btn-sm">

                                                <i class="bi bi-unlock-fill"></i>

                                                Activar

                                            </a>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>