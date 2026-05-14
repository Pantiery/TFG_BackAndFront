<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main>

  <section class="login-hero">
    <div class="login-contenedor">
      <span class="home-etiqueta">Acceso de usuario</span>
      <h1>Inicia sesión</h1>
      <p>
        Accede a tu cuenta para comprar uniformes, solicitar la venta de prendas,
        consultar tus compras y revisar el estado de tus pagos.
      </p>
    </div>
  </section>

  <section class="login-seccion">

    <?php if (isset($_SESSION['mensaje_error'])): ?>
      <div class="alert alert-danger text-center">
        <?= $_SESSION['mensaje_error'] ?>
      </div>
      <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje_exito'])): ?>
      <div class="alert alert-success text-center">
        <?= $_SESSION['mensaje_exito'] ?>
      </div>
      <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>
    
    <div class="login-contenedor login-grid">

      <div class="login-info">
        <h2>Bienvenido de nuevo</h2>
        <p>
          Desde tu cuenta podrás gestionar todas las acciones principales de la plataforma
          de uniformes escolares de segunda mano.
        </p>

        <div class="login-info-card">
          <span class="login-numero">1</span>
          <div>
            <h3>Compra prendas</h3>
            <p>Consulta el catálogo y añade uniformes disponibles a tu carrito.</p>
          </div>
        </div>

        <div class="login-info-card">
          <span class="login-numero">2</span>
          <div>
            <h3>Solicita ventas</h3>
            <p>Envía prendas para que el administrador las revise y publique.</p>
          </div>
        </div>

        <div class="login-info-card">
          <span class="login-numero">3</span>
          <div>
            <h3>Consulta tus pagos</h3>
            <p>Revisa el estado de tus ventas y el importe pendiente en tu monedero.</p>
          </div>
        </div>
      </div>

      <div class="login-form-card">

        <form method="POST" class="grid-layout">

          <h2>Login</h2>
          <p class="login-form-subtitulo">Introduce tus datos para acceder a la plataforma.</p>

          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>

          <label class="form-label">Contraseña</label>
          <input type="password" name="password" class="form-control" required>

          <div class="login-links">
            <p><a href="<?= \App\Config\App::url('/recuperar') ?>">¿Olvidaste tu contraseña?</a></p>
            <p><a href="<?= \App\Config\App::url('/register') ?>">¿No tienes cuenta? Regístrate aquí</a></p>
          </div>

          <button type="submit" class="btn btn-primary">Entrar</button>

        </form>
      </div>

    </div>
  </section>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>