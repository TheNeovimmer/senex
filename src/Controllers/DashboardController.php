<?php
namespace Controllers;
use PDO;
use Services\AuthService;
use Models\UserModel;
use Models\UserProfileModel;
use Models\NotificationModel;
use Models\ChallengeModel;
use Models\ChallengeAttemptModel;
use Models\StreamModel;

class DashboardController {
    protected PDO $pdo;
    protected AuthService $authService;
    protected UserModel $userModel;
    protected UserProfileModel $profileModel;
    protected NotificationModel $notificationModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->authService = new AuthService($pdo);
        $this->userModel = new UserModel($pdo);
        $this->profileModel = new UserProfileModel($pdo);
        $this->notificationModel = new NotificationModel($pdo);
    }

    protected function getLayoutData(): array {
        $user = $this->authService->getCurrentUser();
        $notifications = [];
        $unreadCount = 0;
        if ($user) {
            $notifications = $this->notificationModel->findByUser($user['id'], 10);
            $unreadCount = $this->notificationModel->countUnread($user['id']);
        }
        return [
            'user' => $user,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'csrf' => $this->authService->generateCsrf()
        ];
    }

    protected function render(string $view, array $data = []): void {
        $layoutData = $this->getLayoutData();
        $data = array_merge($layoutData, $data);
        extract($data);
        ob_start();
        require __DIR__ . '/../Views/' . $view . '.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/dashboard/base.php';
    }
}
