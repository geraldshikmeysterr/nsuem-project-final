<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Админ — Блог</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0d0f1a; }
        .panel-card { background: #1a1d27; border: 1px solid #2e3250; border-radius: 12px; }
    </style>
</head>
<body class="p-4">
<div class="container" style="max-width: 800px;">

    <div class="panel-card p-4 mb-4">
        <h1 class="text-white mb-1">Панель администратора</h1>
        <p class="text-secondary mb-4">Управление блогом</p>
        <div class="d-flex gap-2 flex-wrap">
            <a href="?page=write" class="btn btn-primary">+ Написать статью</a>
            <a href="?page=moderate" class="btn btn-warning text-dark">
                Модерация комментариев
                <?php if ($pendingCount > 0): ?>
                    <span class="badge bg-dark ms-1"><?= $pendingCount ?></span>
                <?php endif; ?>
            </a>
            <a href="?page=home" class="btn btn-outline-secondary">На главную</a>
            <a href="?page=logout" class="btn btn-outline-danger">Выйти</a>
        </div>
    </div>

    <div class="panel-card p-4">
        <h5 class="text-white mb-3">Все статьи</h5>
        <?php if (empty($articles)): ?>
            <p class="text-secondary">Статей пока нет.</p>
        <?php else: ?>
            <table class="table table-dark table-borderless">
                <thead><tr>
                    <th class="text-secondary">Заголовок</th>
                    <th class="text-secondary">Дата</th>
                    <th></th>
                </tr></thead>
                <tbody>
                <?php foreach ($articles as $a): ?>
                    <tr>
                        <td class="text-white"><?= h($a['title']) ?></td>
                        <td class="text-secondary small"><?= date('d.m.Y', strtotime($a['created_at'])) ?></td>
                        <td><a href="?page=article&id=<?= $a['id'] ?>" class="btn btn-sm btn-outline-light">Читать</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>
</body>
</html>
