<?php
class ArticleController {

    public function index(): void {
        $this->render('home.php', ['articles' => (new Article())->getAll()]);
    }

    public function show(): void {
        $id      = (int)($_GET['id'] ?? 0);
        $article = (new Article())->getById($id);

        if (!$article) {
            http_response_code(404);
            echo "Статья не найдена.";
            return;
        }

        $this->render('article.php', [
            'article'  => $article,
            'comments' => (new Comment())->getByArticle($id),
        ]);
    }

    public function write(): void {
        $this->requireAdmin();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
                http_response_code(403);
                die('Forbidden');
            }
            $title   = trim($_POST['title'] ?? '');
            $content = $_POST['content'] ?? '';
            $tags    = explode(',', $_POST['tags'] ?? '');

            if (empty($title) || empty($content)) {
                $error = 'Заполните заголовок и текст статьи.';
            } else {
                $id = (new Article())->create($title, $content, $_SESSION['user_id'], $tags);
                header('Location: ?page=article&id=' . $id);
                exit;
            }
        }

        $this->render('admin/write.php', ['error' => $error]);
    }

    public function admin(): void {
        $this->requireAdmin();
        $this->render('admin/panel.php', [
            'articles'     => (new Article())->getAll(),
            'pendingCount' => count((new Comment())->getPending()),
        ]);
    }

    private function requireAdmin(): void {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ?page=login');
            exit;
        }
    }

    private function render(string $template, array $vars = []): void {
        extract($vars, EXTR_SKIP);
        require_once __DIR__ . '/../../templates/' . $template;
    }
}
