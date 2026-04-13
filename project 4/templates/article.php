<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title><?= h($article['title']) ?> — Блог</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0d0f1a; }
        .article-body { background: #1a1d27; border: 1px solid #2e3250; border-radius: 12px; padding: 2rem; }
        .article-content { line-height: 1.8; color: #c9d1e0; }
        .article-content h1, .article-content h2, .article-content h3 { color: #fff; }
        .tag-badge { font-size: 0.72rem; padding: 3px 10px; border-radius: 20px; background: #1e3a5f; color: #7dd3fc; display: inline-block; margin-right: 4px; }
        .comment-card { background: #13151f; border: 1px solid #2e3250; border-radius: 8px; padding: 1rem; margin-bottom: 0.75rem; }
        .author-avatar { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #7c3aed, #06b6d4); display: inline-flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #fff; margin-right: 6px; }
    </style>
</head>
<body>

<?php require_once __DIR__ . '/_nav.php'; ?>

<div class="container py-5" style="max-width: 780px;">
    <a href="?page=home" class="btn btn-outline-secondary btn-sm mb-4">← Назад</a>

    <div class="article-body">
        <div class="mb-3">
            <?php foreach ($article['tags'] as $tag): ?>
                <span class="tag-badge"><?= h($tag) ?></span>
            <?php endforeach; ?>
        </div>

        <h1 class="text-white mb-3"><?= h($article['title']) ?></h1>

        <div class="d-flex align-items-center mb-4 text-secondary small">
            <div class="author-avatar">
                <?= mb_strtoupper(mb_substr($article['author_email'], 0, 1)) ?>
            </div>
            <?= h($article['author_email']) ?>
            <span class="ms-3"><?= date('d.m.Y H:i', strtotime($article['created_at'])) ?></span>
        </div>

        <div class="article-content">
            <?= strip_tags($article['content'], '<p><br><b><strong><i><em><u><s><h1><h2><h3><ul><ol><li><blockquote><pre><code><a><span>') ?>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="text-white mb-3">Комментарии (<?= count($comments) ?>)</h4>

        <?php if (isset($_GET['commented'])): ?>
            <div class="alert alert-info">Комментарий отправлен на модерацию.</div>
        <?php endif; ?>

        <?php foreach ($comments as $c): ?>
            <div class="comment-card">
                <div class="d-flex align-items-center mb-2">
                    <div class="author-avatar">
                        <?= mb_strtoupper(mb_substr($c['author_email'], 0, 1)) ?>
                    </div>
                    <span class="text-secondary small"><?= h($c['author_email']) ?></span>
                    <span class="text-secondary small ms-auto"><?= date('d.m.Y H:i', strtotime($c['created_at'])) ?></span>
                </div>
                <p class="text-light mb-0"><?= h($c['content']) ?></p>
            </div>
        <?php endforeach; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="?page=comment_add" class="mt-4">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                <div class="mb-3">
                    <label for="comment-content" class="form-label text-secondary">Ваш комментарий</label>
                    <textarea id="comment-content" name="content" class="form-control" rows="3" placeholder="Ваш комментарий..." required
                        style="background:#1a1d27;border-color:#2e3250;color:#fff;"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        <?php else: ?>
            <p class="text-secondary mt-3">
                <a href="?page=login" class="text-info">Войдите</a>, чтобы оставить комментарий.
            </p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
