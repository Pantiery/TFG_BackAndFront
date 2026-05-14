<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main>
    <section class="contacto-hero">
        <div class="contacto-contenedor">
            <span class="home-etiqueta">Contacto</span>
            <h1>Estamos aquí para ayudarte</h1>
            <p>
                Ponte en contacto con nosotros para resolver dudas sobre solicitudes de venta,
                compras, pagos pendientes o el funcionamiento general de la plataforma.
            </p>
        </div>
    </section>

    <section class="contacto-seccion">
        <?php require_once __DIR__ . '/../layout/messages.php'; ?>
        <div class="contacto-contenedor contacto-grid">

            <div class="contacto-info">
                <h2>Información de contacto</h2>
                <p>
                    Nuestro equipo revisará tu consulta y te responderá lo antes posible.
                    También puedes consultar la información básica de la plataforma desde esta sección.
                </p>

                <div class="contacto-info-card">
                    <span class="contacto-numero"><i class="bi bi-envelope"></i></span>
                    <div>
                        <h3>Correo electrónico</h3>
                        <a href="mailto:uniformesostenible@gmail.com" class="contacto-link" target="_blank">uniformesostenible@gmail.com</a>
                    </div>
                </div>

                <div class="contacto-info-card">
                    <span class="contacto-numero"><i class="bi bi-whatsapp"></i></span>
                    <div>
                        <h3>Teléfono / WhatsApp</h3>
                        <p>+34 632 71 08 02</p>
                        <p>+34 691 43 28 82</p>
                    </div>
                </div>

                <div class="contacto-info-card">
                    <span class="contacto-numero"><i class="bi bi-clock"></i></span>
                    <div>
                        <h3>Horario de atención</h3>
                        <p>Lunes a viernes, de 9:00 a 14:00.</p>
                    </div>
                </div>
            </div>

            <!-- FORMULARIO DE CONTACTO -->
            <div class="contacto-form-card">

                <h2>Envíanos tu consulta</h2>
                <p class="contacto-form-subtitulo">
                    Rellena el formulario y lo revisaremos cuanto antes.
                </p>
                <form method="POST" action="<?= \App\Config\App::url('/contacto') ?>" class="contacto-form" novalidate>
                    <div class="contacto-form-grid">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control casilla" placeholder="Tu nombre">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="text" id="email" name="email" class="form-control casilla" placeholder="tuemail@ejemplo.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="asunto" class="form-label">Asunto</label>
                        <input type="text" id="asunto" name="asunto" class="form-control casilla" placeholder="Motivo de la consulta">
                    </div>

                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" class="form-control casilla" rows="6" placeholder="Escribe tu mensaje..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 contacto-boton">
                        Enviar consulta
                    </button>
                </form>
            </div>

        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>