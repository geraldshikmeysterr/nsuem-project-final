<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Мой профиль — Блог</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0d0f1a; }
        .profile-card { background: #1a1d27; border: 1px solid #2e3250; border-radius: 12px; }
        .comment-row { background: #13151f; border: 1px solid #2e3250; border-radius: 8px; padding: 1rem; margin-bottom: 0.75rem; }
        .author-avatar {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #7c3aed, #06b6d4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
        }
        .badge-pending  { background: #78350f; color: #fcd34d; }
        .badge-approved { background: #14532d; color: #86efac; }
        .badge-rejected { background: #450a0a; color: #fca5a5; }
    </style>
</head>
<body>
 
<?php require_once __DIR__ . '/_nav.php'; ?>
 
<div class="container py-5" style="max-width: 760px;">
 
    <div class="profile-card p-4 mb-4 d-flex align-items-center gap-4">
        <div class="author-avatar" role="img" aria-label="Аватар пользователя">
            <?= mb_strtoupper(mb_substr($_SESSION['user_email'] ?? 'U', 0, 1)) ?>
        </div>
        <div>
            <h2 class="text-white mb-1"><?= h($_SESSION['user_email'] ?? '') ?></h2>
            <span class="badge bg-secondary"><?= $_SESSION['user_role'] === 'admin' ? 'Администратор' : 'Читатель' ?></span>
        </div>
    </div>
 
    <h4 class="text-white mb-3">Мои комментарии (<?= count($comments) ?>)</h4>
 
    <?php if (empty($comments)): ?>
        <div class="alert alert-secondary">Вы ещё не оставляли комментариев.</div>
    <?php else: ?>
        <?php foreach ($comments as $c): ?>
            <div class="comment-row">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <a href="?page=article&id=<?= $c['article_id'] ?>" class="text-info text-decoration-none small fw-semibold">
                        <?= h($c['article_title']) ?>
                    </a>
                    <?php
                        $badgeClass = match($c['status']) {
                            'approved' => 'badge-approved',
                            'rejected' => 'badge-rejected',
                            default    => 'badge-pending',
                        };
                        $badgeText = match($c['status']) {
                            'approved' => 'Одобрен',
                            'rejected' => 'Отклонён',
                            default    => 'На модерации',
                        };
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                </div>
                <p class="text-light mb-1"><?= h($c['content']) ?></p>
                <small class="text-secondary"><?= date('d.m.Y H:i', strtotime($c['created_at'])) ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
 
</div>
 
</body>
</html>
