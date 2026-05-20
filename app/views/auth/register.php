<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main>

    <section class="register-hero">
        <div class="register-contenedor">
            <h1>Regístrate</h1>
            <p>
                Crea tu cuenta para comprar uniformes escolares de segunda mano,
                solicitar ventas y consultar el estado de tus operaciones.
            </p>
        </div>
    </section>

    <section class="register-seccion">
        <div class="register-contenedor register-grid">

            <div class="register-info">
                <h2>Ventajas de registrarte</h2>
                <p>
                    Una cuenta de usuario te permite participar como comprador y vendedor
                    dentro de la plataforma.
                </p>

                <div class="register-info-card">
                    <span class="register-numero">
                        <i class="fa-solid fa-shirt"></i>
                    </span>
                    <div>
                        <h3>Compra uniformes</h3>
                        <p>Accede al catálogo y filtra prendas por colegio, tipo y estado.</p>
                    </div>
                </div>

                <div class="register-info-card">
                    <span class="register-numero">
                        <i class="fa-solid fa-tag"></i>
                    </span>
                    <div>
                        <h3>Vende prendas</h3>
                        <p>Solicita la venta de uniformes que ya no necesites.</p>
                    </div>
                </div>

                <div class="register-info-card">
                    <span class="register-numero">
                        <i class="fa-solid fa-chart-line"></i>
                    </span>
                    <div>
                        <h3>Gestiona tu actividad</h3>
                        <p>Consulta tus compras, ventas y pagos pendientes.</p>
                    </div>
                </div>
            </div>

            <div class="register-form-card">

                <?php if (isset($_SESSION['mensaje_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['mensaje_error'] ?>
                    </div>
                    <?php unset($_SESSION['mensaje_error']); ?>
                <?php endif; ?>

                <form method="POST" action="/proyecto_TFG/TFG_BackAndFront/public/register" class="grid-layout" onsubmit="return validarForm();" novalidate>

                    <h2>Crear cuenta</h2>
                    <p class="register-form-subtitulo">Rellena tus datos para empezar a usar la plataforma.</p>

                    <div class="register-form-grid">
                        <div class="campo-formulario">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" maxlength="25" required>
                            <div id="div1" class="mensaje-validacion"></div>
                        </div>

                        <div class="campo-formulario">
                            <label for="apellido1" class="form-label">Primer apellido</label>
                            <input type="text" id="apellido1" name="apellido1" class="form-control" maxlength="25" required>
                            <div id="div2" class="mensaje-validacion"></div>
                        </div>

                        <div class="campo-formulario">
                            <label for="apellido2" class="form-label">Segundo apellido (opcional)</label>
                            <input type="text" id="apellido2" name="apellido2" class="form-control" maxlength="25">
                            <div id="div3" class="mensaje-validacion"></div>
                        </div>

                        <div class="campo-formulario">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control" maxlength="100" required>
                            <div id="div4" class="mensaje-validacion"></div>
                        </div>
                    </div>

                    <div class="campo-formulario">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" minlength="8" required>
                        <div id="div5" class="mensaje-validacion"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Registrarme</button>

                    <div class="register-aviso">
                        <p>
                            Nombre y apellidos deben empezar por mayúscula y máximo 25 letras.
                            Mínimo 8 caracteres, una minúscula, una mayúscula,
                            un número y un carácter especial.
                        </p>
                    </div>

                </form>
            </div>

        </div>
    </section>

</main>

<script src="/proyecto_TFG/TFG_BackAndFront/public/js/validaciones.js"></script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>