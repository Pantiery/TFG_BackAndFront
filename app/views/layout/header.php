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
    <link rel="stylesheet" href="../../../public/assets/css/layout.css">
    <!-- Iconos -->
    <link rel="stylesheet" href="/proyecto_TFG/TFG_BackAndFront/public/assets/css/layout.css">
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
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link active" href="/proyecto_TFG/TFG_BackAndFront/public/">Inicio</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="#">Vender</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="#">Contacto</a>
                        </li>

                        <?php if (isset($_SESSION['usuario'])): ?>

                            <li class="nav-item">
                                <a class="nav-link text-primary" href="/proyecto_TFG/TFG_BackAndFront/public/logout">
                                    Cerrar sesión
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link">
                                    👤 <?= $_SESSION['usuario']['nombre'] ?>
                                </a>
                            </li>

                        <?php else: ?>

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

                        <?php endif; ?>

                    </ul>
                    </ul>
                </div>
            </div>
        </nav>
    </section>