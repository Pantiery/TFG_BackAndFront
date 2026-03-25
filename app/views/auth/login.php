<?php require_once __DIR__ . '/../layout/header.php'; ?>

  <form method="POST" class="grid-layout">
        
    <h2>Login</h2>

    <label>Email</label>
    <input type="email" name="email" class="form-control" required>

    <label>Contraseña</label>
    <input type="password" name="password" class="form-control" required>

    <button type="submit" class="btn btn-primary">Entrar</button>

  </form>



<?php require_once __DIR__ . '/../layout/footer.php'; ?>