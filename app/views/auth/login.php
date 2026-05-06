<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main>

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

  <form method="POST" class="grid-layout">

    <h2>Login</h2>

    <label>Email</label>
    <input type="email" name="email" class="form-control" required>

    <label>Contraseña</label>
    <input type="password" name="password" class="form-control" required>

    <button type="submit" class="btn btn-primary">Entrar</button>

  </form>
</main>



<?php require_once __DIR__ . '/../layout/footer.php'; ?>