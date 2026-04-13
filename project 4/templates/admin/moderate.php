<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Модерация — Блог</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0d0f1a; }
        .comment-card { background: #1a1d27; border: 1px solid #2e3250; border-radius: 10px; padding: 1.25rem; margin-bottom: 1rem; }
    </style>
</head>
<body class="p-4">
<div class="container" style="max-width: 780px;">

    <h1 class="text-white mb-1">Модерация комментариев</h1>
    <a href="?page=admin" class="btn btn-outline-secondary btn-sm mb-4">← Назад</a>

    <?php if (empty($comments)): ?>
        <div class="alert alert-success">Нет комментариев на модерации.</div>
    <?php else: ?>
        <?php foreach ($comments as $c): ?>
            <div class="comment-card">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-info small"><?= h($c['author_email']) ?></span>
                    <span class="text-secondary small">
                        Статья: <a href="?page=article&id=<?= $c['article_id'] ?>" class="text-light" aria-label="Перейти к статье: <?= h($c['article_title']) ?>"><?= h($c['article_title']) ?></a>
                    </span>
                </div>
                <p class="text-light mb-3"><?= h($c['content']) ?></p>
                <div class="d-flex gap-2">
                    <form method="POST" action="?page=comment_action">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <input type="hidden" name="status" value="approved">
                        <button class="btn btn-sm btn-success">Одобрить</button>
                    </form>
                    <form method="POST" action="?page=comment_action">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <input type="hidden" name="status" value="rejected">
                        <button class="btn btn-sm btn-danger">Отклонить</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
</body>
</html>
