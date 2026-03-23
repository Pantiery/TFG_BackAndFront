<?php require_once __DIR__ . '/../layout/header.php'; ?>
<p>HOME FUNCIONANDO 🔥</p>

<?php if (isset($_SESSION['user'])): ?>
    <p>Bienvenido <?= $_SESSION['user'] ?></p>
<?php endif; ?>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>