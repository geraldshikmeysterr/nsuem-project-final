<nav class="navbar px-4 py-3" style="background-color:#13151f;border-bottom:1px solid #2e3250;">
    <a href="?page=home" class="navbar-brand fw-bold text-white text-decoration-none">Блог</a>
    <div class="d-flex gap-2 align-items-center">
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <a href="?page=admin" class="btn btn-sm btn-outline-warning">Админка</a>
                <a href="?page=write" class="btn btn-sm btn-primary">+ Статья</a>
            <?php endif; ?>
            <a href="?page=profile" class="btn btn-sm btn-outline-info">Мой профиль</a>
            <a href="?page=logout" class="btn btn-sm btn-outline-secondary">Выйти</a>
        <?php else: ?>
            <a href="?page=login" class="btn btn-sm btn-outline-light">Войти</a>
            <a href="?page=register" class="btn btn-sm btn-outline-secondary">Регистрация</a>
        <?php endif; ?>
    </div>
</nav>
