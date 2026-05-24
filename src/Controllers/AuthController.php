<?php
namespace Controllers;
use Services\AuthService;
use PDO;

class AuthController {
    private AuthService $authService;

    public function __construct(PDO $pdo) {
        $this->authService = new AuthService($pdo);
    }

    public function showLogin(): void {
        require_once __DIR__ . '/../Views/login.php';
    }

    public function showSignin(): void {
        require_once __DIR__ . '/../Views/signin.php';
    }

    public function loginPost(): void {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $result = $this->authService->login($email, $password);

        if ($result['success']) {
            $redirect = $_SESSION['redirect_after'] ?? '/dashboard';
            unset($_SESSION['redirect_after']);
            header("Location: $redirect");
        } else {
            $_SESSION['error'] = $result['error'];
            header('Location: /login');
        }
        exit;
    }

    public function signinPost(): void {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm) {
            $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
            header('Location: /signin');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Le mot de passe doit contenir au moins 6 caractères.';
            header('Location: /signin');
            exit;
        }

        $result = $this->authService->register($username, $email, $password);

        if ($result['success']) {
            $_SESSION['message'] = 'Compte créé avec succès! Vous pouvez maintenant vous connecter.';
            header('Location: /login');
        } else {
            $_SESSION['error'] = $result['error'];
            header('Location: /signin');
        }
        exit;
    }

    public function logout(): void {
        $this->authService->logout();
        header('Location: /home');
        exit;
    }
}
