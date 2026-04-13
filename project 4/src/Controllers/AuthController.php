<?php
class AuthController {

    private const REDIRECT_HOME = 'Location: ?page=home';

    private function validateCsrf(): void {
        if (($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            die('Forbidden');
        }
    }

    public function register(): void {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $email = trim($_POST['email'] ?? '');
            $pass  = trim($_POST['password'] ?? '');
            $pass2 = trim($_POST['password2'] ?? '');

            if (empty($email) || empty($pass)) {
                $error = 'Заполните все поля.';
            } elseif ($pass !== $pass2) {
                $error = 'Пароли не совпадают.';
            } elseif (strlen($pass) < 6) {
                $error = 'Пароль должен быть не менее 6 символов.';
            } else {
                $userModel = new User();
                if ($userModel->findByEmail($email)) {
                    $error = 'Этот email уже зарегистрирован.';
                } else {
                    $userModel->create($email, $pass);
                    header('Location: ?page=login&success=1');
                    exit;
                }
            }
        }

        $this->render('login_register.php', ['error' => $error]);
    }

    public function login(): void {
        $error = '';

        if (isset($_SESSION['user_id'])) {
            header(self::REDIRECT_HOME);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $email = trim($_POST['email'] ?? '');
            $pass  = $_POST['password'] ?? '';

            $user = (new User())->findByEmail($email);

            if ($user && password_verify($pass, $user['password_hash'])) {
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_role']  = $user['role'];
                $_SESSION['user_email'] = $user['email'];
                header($user['role'] === 'admin' ? 'Location: ?page=admin' : self::REDIRECT_HOME);
                exit;
            }

            $error = 'Неверный логин или пароль.';
        }

        $this->render('login_register.php', ['error' => $error]);
    }

    public function logout(): void {
        session_destroy();
        header(self::REDIRECT_HOME);
        exit;
    }

    private function render(string $template, array $vars = []): void {
        extract($vars, EXTR_SKIP);
        require_once __DIR__ . '/../../templates/' . $template;
    }
}
