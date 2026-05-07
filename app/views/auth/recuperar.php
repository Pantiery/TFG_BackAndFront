<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main>

    <section class="admin-hero">

        <div class="admin-contenedor">

            <span class="home-etiqueta">
                Recuperación de cuenta
            </span>

            <h1>
                ¿Olvidaste tu contraseña?
            </h1>

            <p>
                Introduce tu correo electrónico y te enviaremos
                instrucciones para recuperar el acceso a tu cuenta.
            </p>

        </div>

    </section>

    <section class="admin-seccion">

        <div class="admin-contenedor">

            <div class="admin-card">

                <div class="admin-card-body">

                    <form method="POST">

                        <div class="mb-4">

                            <label class="form-label">
                                Correo electrónico
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Enviar recuperación

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>