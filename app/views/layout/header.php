<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML, CSS, JavaScrip, Bootstrap">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tu uniforme escolar</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="<?= \App\Config\App::url('/assets/img/logo/logoUniformes.png') ?>">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/catalogo.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/home.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/layout.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/login.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/misCompras.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/misVentas.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/monedero.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/solicitar.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/admin.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/recuperar.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/register.css') ?>">
    <link rel="stylesheet" href="<?= \App\Config\App::url('/assets/css/contacto.css') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:wght@400;500;700&family=Lobster&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-xxl navbar-light sticky-top">
        <div class="container-fluid">

            <a class="navbar-brand d-flex align-items-center" href="<?= \App\Config\App::url('/') ?>">
                <img src="<?= \App\Config\App::url('/assets/img/logo/logoUniformes.png') ?>"
                    alt="Logo"
                    width="65"
                    height="65"
                    class="me-2">

                <span>UniColegio</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'user'): ?>

                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/') ?>">Inicio</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/prendas/catalogo') ?>">Catálogo</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/prendas/solicitar') ?>">Solicitar Venta</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/prendas/misVentas') ?>">Mis Ventas</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/prendas/misCompras') ?>">Mis Compras</a>
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

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/monedero') ?>">Monedero</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/carrito') ?>">
                                Carrito
                                <span class="badge text-bg-dark rounded-pill ms-2" id="contador-carrito">
                                    <?= count($productos ?? []) ?>
                                </span>
                            </a>
                        </li>
                    </ul>

                <?php elseif (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>

                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/') ?>">
                                Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active"
                                href="<?= \App\Config\App::url('/admin/prendas-pendientes') ?>">
                                Gestión de Prendas
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active"
                                href="<?= \App\Config\App::url('/admin/ventas') ?>">
                                Gestión de Ventas
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/admin/usuarios') ?>">
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

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= \App\Config\App::url('/admin/estadisticas') ?>">
                                Estadísticas
                            </a>
                        </li>

                    </ul>

                <?php else: ?>

                    <ul class="navbar-nav mx-auto">

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