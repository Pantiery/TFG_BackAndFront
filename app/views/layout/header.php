<!DOCTYPE html>
<html>

<head>
    <!-- Metadatos -->
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML, CSS, JavaScrip, Bootstrap">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Titulo -->
    <title>Tu uniforme escolar</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="">
    <!-- Enlace Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a CSS -->
    <link rel="stylesheet" href="/proyecto_TFG/TFG_BackAndFront/public/assets/css/layout.css">
    <!-- Iconos -->

</head>

<body>
    <section>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Uniformes segunda mano</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">

                    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'user'): ?>

                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link active" href="/proyecto_TFG/TFG_BackAndFront/public/">
                                    Inicio
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="">
                                    Catálogo
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="/proyecto_TFG/TFG_BackAndFront/public/prendas/solicitar">
                                    Solicitar Venta
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="/proyecto_TFG/TFG_BackAndFront/public/prendas/misVentas">
                                    Mis Ventas
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="">
                                    Mis Compras
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-primary" href="/proyecto_TFG/TFG_BackAndFront/public/logout">
                                    Cerrar Sesión
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">
                                    👤
                                    <?= $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido1'] . " " . "(" . $_SESSION['usuario']['rol'] . ")" ?>
                                </a>
                            </li>

                        </ul>

                        <ul class="navbar-nav ms-auto">

                            <li class="nav-item">
                                <a class="nav-link active" href="">
                                    Monedero
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="">
                                    Carrito
                                </a>
                            </li>

                        </ul>

                    <?php elseif (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link active" href="/proyecto_TFG/TFG_BackAndFront/public/">
                                    Inicio
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="">
                                    Gestión de Prendas
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="">
                                    Gestión de Ventas
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="">
                                    Gestión de Usuarios
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-primary" href="/proyecto_TFG/TFG_BackAndFront/public/logout">
                                    Cerrar sesión
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">
                                    👤
                                    <?= $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido1'] . " " . "(" . $_SESSION['usuario']['rol'] . ")" ?>
                                </a>
                            </li>

                        </ul>

                        <ul class="navbar-nav ms-auto">

                            <li class="nav-item">
                                <a class="nav-link active" href="">
                                    Estadísticas
                                </a>
                            </li>

                        </ul>

                    <?php else: ?>
                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link active" href="/proyecto_TFG/TFG_BackAndFront/public/">
                                    Inicio
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="">
                                    Catálogo
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-primary" href="/proyecto_TFG/TFG_BackAndFront/public/login">
                                    Iniciar sesión
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="/proyecto_TFG/TFG_BackAndFront/public/register">
                                    Registrate
                                </a>
                            </li>

                        </ul>

                    <?php endif; ?>

                </div>
            </div>
        </nav>
    </section>