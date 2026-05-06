<footer class="footer">
    <div class="container py-5">
        <div class="row g-4">

            <div class="col-md-3">
                <h5 class="footer-title">UniColegio</h5>
                <p class="footer-text">
                    Plataforma para la compra y venta de uniformes escolares de segunda mano.
                </p>
                <p class="footer-text">© 2026 UniColegio</p>
            </div>

            <div class="col-md-3">
                <h6 class="footer-title">Navegación</h6>
                <ul class="footer-list">
                    <li><a href="<?= \App\Config\App::url('/') ?>" class="footer-link">Inicio</a></li>
                    <li><a href="<?= \App\Config\App::url('/prendas/catalogo') ?>" class="footer-link">Catálogo</a></li>
                    <li><a href="<?= \App\Config\App::url('/prendas/solicitar') ?>" class="footer-link">Solicitar venta</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h6 class="footer-title">Información</h6>
                <ul class="footer-list">
                    <li>Precios estándar</li>
                    <li>Comisión fija del 10%</li>
                    <li>Pagos gestionados por administrador</li>
                    <li>Uniformes revisados antes de publicarse</li>
                </ul>
            </div>

            <div class="col-md-3">
                <h6 class="footer-title">Contacto</h6>

                <p class="footer-text mb-2">
                    <i class="bi bi-whatsapp"></i>
                    +34 632 71 08 02
                </p>

                <p class="footer-text mb-2">
                    Visita nuestras redes:
                </p>

                <div class="footer-redes">
                    <a href="#" class="footer-social">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="#" class="footer-social">
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a href="#" class="footer-social">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                </div>
            </div>

        </div>

        <hr class="footer-line">

        <div class="footer-bottom">
            <p>Reutiliza, ahorra y da una segunda vida a los uniformes escolares.</p>
        </div>
    </div>
</footer>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/proyecto_TFG/TFG_BackAndFront/public/assets/js/validaciones.js"></script>
<script src="/proyecto_TFG/TFG_BackAndFront/public/assets/js/mensajes.js"></script>
</body>
</html>