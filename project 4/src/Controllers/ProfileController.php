<?php
class ProfileController {

    public function show(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }

        // Anti-IDOR: user_id берётся только из сессии, не из $_GET/$_POST.
        // Пользователь видит исключительно свои данные.
        $this->render('profile.php', [
            'comments' => (new Comment())->getByUser($_SESSION['user_id']),
        ]);
    }

    private function render(string $template, array $vars = []): void {
        extract($vars, EXTR_SKIP);
        require_once __DIR__ . '/../../templates/' . $template;
    }
}
