<?php
session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/src/Models/User.php';
require_once __DIR__ . '/src/Models/Article.php';
require_once __DIR__ . '/src/Models/Comment.php';
require_once __DIR__ . '/src/Controllers/AuthController.php';
require_once __DIR__ . '/src/Controllers/ArticleController.php';
require_once __DIR__ . '/src/Controllers/CommentController.php';
require_once __DIR__ . '/src/Controllers/ProfileController.php';

function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        (new ArticleController())->index();
        break;
    case 'article':
        (new ArticleController())->show();
        break;
    case 'write':
        (new ArticleController())->write();
        break;
    case 'admin':
        (new ArticleController())->admin();
        break;
    case 'login':
        (new AuthController())->login();
        break;
    case 'register':
        (new AuthController())->register();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    case 'comment_add':
        (new CommentController())->add();
        break;
    case 'moderate':
        (new CommentController())->moderate();
        break;
    case 'comment_action':
        (new CommentController())->action();
        break;
    case 'profile':
        (new ProfileController())->show();
        break;
    default:
        http_response_code(404);
        echo "Страница не найдена.";
}
