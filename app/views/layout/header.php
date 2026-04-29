<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML, CSS, JavaScrip, Bootstrap">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tu uniforme escolar</title>

    <link rel="icon" type="image/x-icon" href="">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/layout.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/cards.css') ?>">
</head>

<body>
<section>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">

        <a class="navbar-brand" href="<?= \App\Config\App::url('/') ?>">
            Uniformes segunda mano
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'user'): ?>

            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/') ?>">
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/prendas/catalogo') ?>">
                        Catálogo
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/prendas/solicitar') ?>">
                        Solicitar Venta
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/prendas/misVentas') ?>">
                        Mis Ventas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/prendas/misCompras') ?>">
                        Mis Compras
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-primary" href="<?= \App\Config\App::url('/logout') ?>">
                        Cerrar Sesión
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled" href="#">
                        👤
                        <?= $_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellido1'] . ' (' . $_SESSION['usuario']['rol'] . ')' ?>
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        Monedero
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/carrito') ?>">
                        Carrito
                        <span class="badge text-bg-dark rounded-pill px-3 py-2 ms-2">
                            <?= count($productos ?? []) ?>
                        </span>
                    </a>
                </li>

            </ul>

        <?php elseif (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>

            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/') ?>">
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        Gestión de Prendas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        Gestión de Ventas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        Gestión de Usuarios
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-primary" href="<?= \App\Config\App::url('/logout') ?>">
                        Cerrar sesión
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled" href="#">
                        👤
                        <?= $_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellido1'] . ' (' . $_SESSION['usuario']['rol'] . ')' ?>
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        Estadísticas
                    </a>
                </li>

            </ul>

        <?php else: ?>

            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/') ?>">
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/prendas/catalogo') ?>">
                        Catálogo
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-primary" href="<?= \App\Config\App::url('/login') ?>">
                        Iniciar sesión
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="<?= \App\Config\App::url('/register') ?>">
                        Regístrate
                    </a>
                </li>

            </ul>

        <?php endif; ?>

        </div>
    </div>
</nav>
</section>