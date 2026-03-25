<?php require_once __DIR__ . '/../layout/header.php'; ?>

<h2>Login</h2>

<form action="" method="POST">
  <div class="row mb-3">
    <label class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="email" name="email" class="form-control w-50" required>
    </div>
  </div>

  <div class="row mb-3">
    <label class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" name="password" class="form-control w-50" required>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Entrar</button>
</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>