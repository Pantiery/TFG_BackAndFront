<?php

$titulo = 'Home';
$tituloHero = 'Bienvenido a nuestra tienda de prendas';
$subtituloHero = 'Descubre las últimas tendencias en moda y encuentra tu estilo único con nosotros.';

$imagenes = [
    '/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-home.webp',
    '/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-home2.jpg',
    '/proyecto_TFG/TFG_BackAndFront/public/assets/img/hero/hero-home3.jpg',
];

require_once __DIR__ . '/../layout/header.php';
?>

<main>

    

    <?php require_once __DIR__ . '/../../../components/component-hero-basico.php'; ?>

    

    <section class="home-presentacion">
        <div class="home-contenedor">
            <?php require_once __DIR__ . '/../layout/messages.php'; ?>
            <span class="home-etiqueta">Uniformes escolares de segunda mano</span>
            <h1>Compra el uniforme de tu colegio al mejor precio</h1>
            <p>
                En UniColegio ayudamos a las familias a comprar y vender uniformes escolares en buen estado,
                fomentando el ahorro, la reutilización de prendas y un consumo más responsable.
            </p>

            <div class="home-acciones">
                <a href="<?= \App\Config\App::baseUrl() ?>/prendas/catalogo" class="btn-home btn-home-principal">
                    Ver catálogo
                </a>
                <a href="<?= \App\Config\App::baseUrl() ?>/prendas/solicitar" class="btn-home btn-home-secundario">
                    Solicitar venta
                </a>
            </div>
        </div>
    </section>

    <section class="home-bloque home-claro">
        <div class="home-contenedor">
            <div class="home-grid-2">
                <div>
                    <h2>¿Cuál es nuestro objetivo?</h2>
                    <p>
                        Nuestro objetivo es centralizar la compra y venta de uniformes escolares de segunda mano
                        en una plataforma sencilla, accesible desde cualquier navegador y pensada para familias.
                    </p>
                    <p>
                        Cada prenda es revisada antes de aparecer publicada, para asegurar que el catálogo mantenga
                        productos útiles, claros y organizados por colegio, tipo de prenda y estado.
                    </p>
                </div>

                <div class="home-card-destacada">
                    <h3>Ventajas principales</h3>
                    <ul>
                        <li>Ahorro económico para las familias.</li>
                        <li>Reutilización de prendas en buen estado.</li>
                        <li>Catálogo filtrado por colegio, tipo y estado.</li>
                        <li>Gestión controlada por administradores.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="home-bloque">
        <div class="home-contenedor">
            <h2 class="home-titulo-centro">¿Cómo funciona?</h2>

            <div class="home-pasos">
                <article class="home-card">
                    <span class="home-numero">1</span>
                    <h3>Solicita la venta</h3>
                    <p>El vendedor registra la prenda indicando su tipo, colegio y estado de conservación.</p>
                </article>

                <article class="home-card">
                    <span class="home-numero">2</span>
                    <h3>Regogida en colegio</h3>
                    <p>Se le enviará un mensaje al vendedor para citarlo en un colegio indicado y la prenda la recogerá uno de nuestros trabajadores.</p>
                </article>

                <article class="home-card">
                    <span class="home-numero">3</span>
                    <h3>Revisión de la prenda</h3>
                    <p>La prenda, una vez en nuestra tienda y revisada por un administrador, se decidirá si la prenda se aprueba o se rechaza.</p>
                </article>

                <article class="home-card">
                    <span class="home-numero">4</span>
                    <h3>Publicación en catálogo</h3>
                    <p>Si se aprueba, la prenda aparece en el catálogo para que otros usuarios puedan comprarla.</p>
                </article>

                <article class="home-card">
                    <span class="home-numero">5</span>
                    <h3>Compra y monedero</h3>
                    <p>Cuando se vende, el importe queda reflejado en el monedero del vendedor como pago pendiente.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="home-bloque home-claro">
        <div class="home-contenedor">
            <div class="home-grid-2">
                <div class="home-card-destacada">
                    <h2>Precios claros y controlados</h2>
                    <p>
                        Los vendedores no deciden el precio de las prendas. La plataforma asigna precios estándar
                        según el tipo de prenda y su estado de conservación.
                    </p>
                    <p>
                        Además, UniColegio aplica una comisión fija del 10% sobre el precio de venta. Así se mantiene
                        un sistema justo, transparente y fácil de gestionar.
                    </p>
                </div>

                <div>
                    <h2>Colegios colaboradores</h2>
                    <p>
                        Actualmente trabajamos con varios centros educativos para organizar el catálogo y facilitar
                        que cada familia encuentre rápidamente las prendas correspondientes a su colegio.
                    </p>

                    <div class="home-colegios">
                        <span>Colegio Juan Pablo Segundo</span>
                        <span>IES Julio Verne</span>
                        <span>IES María Zambrano</span>
                        <span>Y más...</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-bloque home-cta">
        <div class="home-contenedor">
            <h2>Da una segunda vida a los uniformes escolares</h2>
            <p>
                Compra prendas a precios accesibles o solicita la venta de uniformes que ya no utilizas.
            </p>
            <a href="<?= \App\Config\App::baseUrl() ?>/prendas/catalogo" class="btn-home btn-home-principal">
                Ir al catálogo
            </a>
        </div>
    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>