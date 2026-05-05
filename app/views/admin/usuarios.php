<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Listado de usuarios</h2>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['mensaje'] ?>
        </div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php
            /** @var array $usuarios */
            foreach ($usuarios as $user):
            ?>
                <tr>
                    <td><?= $user['id'] ?></td>

                    <td>
                        <?= $user['nombre'] . ' ' . $user['apellido1'] ?>
                    </td>

                    <td><?= $user['email'] ?></td>

                    <td><?= $user['rol'] ?></td>

                    <td>
                        <?= $user['activo'] ? 'Activo' : 'Bloqueado' ?>
                    </td>

                    <td>
                        <?php if ($user['activo'] == 1): ?>
                            <a href="<?= \App\Config\App::url('/admin/usuarios/bloquear?id=' . $user['id']) ?>"
                                class="btn btn-danger btn-sm">
                                Bloquear
                            </a>
                        <?php else: ?>
                            <a href="<?= \App\Config\App::url('/admin/usuarios/activar?id=' . $user['id']) ?>"
                                class="btn btn-success btn-sm">
                                Activar
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>