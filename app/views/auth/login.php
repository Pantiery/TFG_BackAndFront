<?php require_once __DIR__ . '/../layout/header.php'; ?>

<h2>Login</h2>

<form method="POST" action="/login">
    <div>
        <label>Email:</label>
        <input type="text" name="email" required>
    </div>

    <div>
        <label>Password:</label>
        <input type="password" name="password" required>
    </div>

    <button type="submit">Entrar</button>
</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>