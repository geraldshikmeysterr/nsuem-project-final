<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title><?= isset($_GET['page']) && $_GET['page'] === 'register' ? 'Регистрация' : 'Вход' ?> — Блог</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0d0f1a; }
        .card { background-color: #1a1d27; border: 1px solid #2e3250; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 420px;">

        <?php $isRegister = isset($_GET['page']) && $_GET['page'] === 'register'; ?>
        <h2 class="mb-4 text-center text-white"><?= $isRegister ? 'Регистрация' : 'Вход' ?></h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Регистрация прошла успешно!</div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="mb-3">
                <label for="email" class="form-label text-secondary">Email</label>
                <input type="email" id="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-secondary">Пароль</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <?php if ($isRegister): ?>
                <div class="mb-3">
                    <label for="password2" class="form-label text-secondary">Повторите пароль</label>
                    <input type="password" id="password2" name="password2" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Зарегистрироваться</button>
                <p class="mt-3 text-center text-secondary">Уже есть аккаунт? <a href="?page=login" class="text-info">Войти</a></p>
            <?php else: ?>
                <button type="submit" class="btn btn-primary w-100">Войти</button>
                <p class="mt-3 text-center text-secondary">Нет аккаунта? <a href="?page=register" class="text-info">Зарегистрироваться</a></p>
            <?php endif; ?>
        </form>
    </div>
</div>
</body>
</html>
