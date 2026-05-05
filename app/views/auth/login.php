<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main>

  <form method="POST" class="grid-layout">

    <h2>Login</h2>

    <label>Email</label>
    <input type="email" name="email" class="form-control" required>

    <label>Contraseña</label>
    <input type="password" name="password" class="form-control" required>

    <button type="submit" class="btn btn-primary">Entrar</button>
    
    <?php if (isset($_SESSION['error_credenciales'])): ?>
      <div class="alert alert-danger">
        <?= $_SESSION['error_credenciales'] ?>
      </div>
      <?php unset($_SESSION['error_credenciales']); ?>
    <?php endif; ?>

  </form>
</main>



<?php require_once __DIR__ . '/../layout/footer.php'; ?>