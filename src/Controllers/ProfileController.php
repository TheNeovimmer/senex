<?php
namespace Controllers;
use PDO;
use Models\UserModel;
use Models\UserProfileModel;
use Models\UserBadgeModel;

class ProfileController {
    private PDO $pdo;
    private UserModel $userModel;
    private UserProfileModel $profileModel;
    private UserBadgeModel $userBadgeModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->userModel = new UserModel($pdo);
        $this->profileModel = new UserProfileModel($pdo);
        $this->userBadgeModel = new UserBadgeModel($pdo);
    }

    public function showProfile(int $userId): void {
        $profileUser = $this->userModel->findById($userId);
        if (!$profileUser) {
            header('Location: /');
            exit;
        }
        $profile = $this->profileModel->findByUserId($userId);
        $badges = $this->userBadgeModel->findByUser($userId);

        $title = 'Profil - ' . $profileUser['username'];
        ob_start();
        require __DIR__ . '/../Views/profile.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }
}
