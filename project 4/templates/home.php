<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Блог</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0d0f1a; }

        /* Animata: bg-position gradient animation */
        @keyframes bg-position {
            0%   { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        /* Animata: flip-words animation */
        @keyframes flip-words {
            10%  { transform: translateY(-112%); }
            25%  { transform: translateY(-100%); }
            35%  { transform: translateY(-212%); }
            50%  { transform: translateY(-200%); }
            60%  { transform: translateY(-312%); }
            75%  { transform: translateY(-300%); }
            85%  { transform: translateY(-412%); }
            100% { transform: translateY(-400%); }
        }

        .hero {
            background: linear-gradient(270deg, #1a1d3a, #0d2040, #1a0d2e, #0d1a2e);
            background-size: 400% 400%;
            animation: bg-position 8s linear infinite alternate;
            padding: 80px 0 60px;
            text-align: center;
        }
        .hero h1 { font-size: 3rem; font-weight: 800; color: #fff; }

        .flip-container {
            display: inline-flex;
            gap: 12px;
            font-size: 1.8rem;
            font-weight: 600;
            justify-content: center;
        }
        .flip-words {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            height: 1.4em;
            color: #7dd3fc;
        }
        .flip-words span { animation: flip-words 8s infinite; }

        /* Animata: card hover 3D effect */
        .article-card {
            background-color: #1a1d27;
            border: 1px solid #2e3250;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            perspective: 1000px;
        }
        .article-card:hover {
            transform: translateY(-6px) rotateX(2deg);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .article-card .card-body { padding: 1.5rem; }
        .tag-badge {
            font-size: 0.72rem;
            padding: 3px 10px;
            border-radius: 20px;
            background: #1e3a5f;
            color: #7dd3fc;
            display: inline-block;
            margin-right: 4px;
        }
        .author-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #7c3aed, #06b6d4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: #fff;
            margin-right: 6px;
        }
    </style>
</head>
<body>

<?php require_once __DIR__ . '/_nav.php'; ?>

<div class="hero">
    <h1>Коллективный блог</h1>
    <div class="flip-container mt-3">
        <span class="text-secondary">Пишем про</span>
        <div class="flip-words">
            <span>технологии</span>
            <span>дизайн</span>
            <span>код</span>
            <span>идеи</span>
            <span>технологии</span>
        </div>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="?page=write" class="btn btn-primary px-4 ms-4" style="font-size:1rem;">+ Написать статью</a>
        <?php endif; ?>
    </div>
</div>

<div class="container py-5">
    <?php if (empty($articles)): ?>
        <div class="alert alert-secondary text-center">Статей пока нет.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($articles as $a): ?>
                <div class="col-md-4">
                    <a href="?page=article&id=<?= $a['id'] ?>" class="text-decoration-none">
                        <div class="article-card h-100">
                            <div class="card-body">
                                <div class="mb-2">
                                    <?php foreach ($a['tags'] as $tag): ?>
                                        <span class="tag-badge"><?= h($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <h5 class="text-white mb-2"><?= h($a['title']) ?></h5>
                                <p class="text-secondary small">
                                    <?= h(mb_strimwidth(strip_tags($a['content']), 0, 120, '…')) ?>
                                </p>
                                <div class="d-flex align-items-center mt-3">
                                    <div class="author-avatar">
                                        <?= mb_strtoupper(mb_substr($a['author_email'], 0, 1)) ?>
                                    </div>
                                    <span class="text-secondary small"><?= h($a['author_email']) ?></span>
                                    <span class="text-secondary small ms-auto">
                                        <?= date('d.m.Y', strtotime($a['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
