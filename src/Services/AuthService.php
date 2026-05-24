<?php
namespace Services;
use PDO;
use Models\UserModel;
use Models\UserProfileModel;
use Models\NotificationModel;

class AuthService {
    private UserModel $userModel;
    private UserProfileModel $profileModel;
    private NotificationModel $notificationModel;

    public function __construct(PDO $pdo) {
        $this->userModel = new UserModel($pdo);
        $this->profileModel = new UserProfileModel($pdo);
        $this->notificationModel = new NotificationModel($pdo);
    }

    public function register(string $username, string $email, string $password, string $role = 'user'): array {
        if ($this->userModel->findByEmail($email)) {
            return ['success' => false, 'error' => 'Cet email est déjà utilisé.'];
        }
        if ($this->userModel->findByUsername($username)) {
            return ['success' => false, 'error' => 'Ce nom d\'utilisateur est déjà pris.'];
        }
        $userId = $this->userModel->createUser([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);
        if (!$userId) {
            return ['success' => false, 'error' => 'Erreur lors de la création du compte.'];
        }
        $this->profileModel->insert(['user_id' => $userId]);
        $this->notificationModel->notify($userId, 'welcome', 'Bienvenue sur SENEX!', 'Votre compte a été créé avec succès.');
        return ['success' => true, 'user_id' => $userId];
    }

    public function login(string $email, string $password): array {
        $user = $this->userModel->verifyPassword($email, $password);
        if (!$user) {
            return ['success' => false, 'error' => 'Email ou mot de passe incorrect.'];
        }
        if (($user['is_active'] ?? true) === false || ($user['is_banned'] ?? false)) {
            return ['success' => false, 'error' => 'Votre compte a été désactivé.'];
        }
        $this->userModel->updateLastLogin($user['id']);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'] ?? 'user';
        $_SESSION['logged_in'] = true;
        return ['success' => true, 'user' => $user];
    }

    public function logout(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
    }

    public function getCurrentUser(): ?array {
        if (!isset($_SESSION['user_id'])) return null;
        return $this->userModel->findById($_SESSION['user_id']);
    }

    public function isLoggedIn(): bool {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function hasRole(string ...$roles): bool {
        return $this->isLoggedIn() && in_array($_SESSION['role'] ?? '', $roles);
    }

    public function requireAuth(): void {
        if (!$this->isLoggedIn()) {
            $_SESSION['redirect_after'] = $_SERVER['REQUEST_URI'];
            header('Location: /login');
            exit;
        }
    }

    public function requireRole(string ...$roles): void {
        $this->requireAuth();
        if (!in_array($_SESSION['role'] ?? '', $roles)) {
            header('Location: /dashboard');
            exit;
        }
    }

    public function generateCsrf(): string {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public function verifyCsrf(string $token): bool {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
