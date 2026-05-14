<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main>

    <section class="recuperar-hero">
        <div class="recuperar-contenedor">
            <span class="home-etiqueta">Recuperación de cuenta</span>
            <h1>¿Olvidaste tu contraseña?</h1>
            <p>
                Introduce tu correo electrónico y te enviaremos instrucciones
                para recuperar el acceso a tu cuenta.
            </p>
        </div>
    </section>

    <section class="recuperar-seccion">
        <div class="recuperar-contenedor recuperar-grid">

            <div class="recuperar-info">
                <h2>Recupera tu acceso</h2>
                <p>
                    Te ayudaremos a volver a entrar en tu cuenta para que puedas seguir
                    gestionando tus compras, ventas y pagos pendientes.
                </p>

                <div class="recuperar-info-card">
                    <span class="recuperar-numero">1</span>
                    <div>
                        <h3>Introduce tu email</h3>
                        <p>Debe ser el mismo correo que utilizaste al registrarte.</p>
                    </div>
                </div>

                <div class="recuperar-info-card">
                    <span class="recuperar-numero">2</span>
                    <div>
                        <h3>Revisa las instrucciones</h3>
                        <p>Sigue los pasos indicados para recuperar tu cuenta.</p>
                    </div>
                </div>
            </div>

            <div class="recuperar-form-card">
                <form method="POST" class="grid-layout">

                    <h2>Recuperar contraseña</h2>
                    <p class="recuperar-form-subtitulo">Escribe tu correo electrónico para continuar.</p>

                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" required>

                    <button type="submit" class="btn btn-primary">Enviar recuperación</button>

                </form>
            </div>

        </div>
    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
