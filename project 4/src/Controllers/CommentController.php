<?php
class CommentController {

    public function add(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }

        if (($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            die('Forbidden');
        }

        $articleId = (int)($_POST['article_id'] ?? 0);
        $content   = trim($_POST['content'] ?? '');

        if ($articleId && $content !== '') {
            (new Comment())->create($articleId, $_SESSION['user_id'], $content);
        }

        header('Location: ?page=article&id=' . $articleId . '&commented=1');
        exit;
    }

    public function moderate(): void {
        $this->requireAdmin();
        $this->render('admin/moderate.php', ['comments' => (new Comment())->getPending()]);
    }

    public function action(): void {
        $this->requireAdmin();
        if (($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            die('Forbidden');
        }
        $id     = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if ($id && in_array($status, ['approved', 'rejected'], true)) {
            (new Comment())->setStatus($id, $status);
        }

        header('Location: ?page=moderate');
        exit;
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
