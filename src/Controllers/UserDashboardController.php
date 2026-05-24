<?php
namespace Controllers;
use PDO;
use Models\ChallengeModel;
use Models\ChallengeAttemptModel;
use Models\FollowModel;
use Models\UserBadgeModel;
use Models\BadgeModel;
use Models\StreamModel;

class UserDashboardController extends DashboardController {
    private ChallengeModel $challengeModel;
    private ChallengeAttemptModel $attemptModel;
    private FollowModel $followModel;
    private UserBadgeModel $userBadgeModel;
    private BadgeModel $badgeModel;
    private StreamModel $streamModel;

    public function __construct(PDO $pdo) {
        parent::__construct($pdo);
        $this->challengeModel = new ChallengeModel($pdo);
        $this->attemptModel = new ChallengeAttemptModel($pdo);
        $this->followModel = new FollowModel($pdo);
        $this->userBadgeModel = new UserBadgeModel($pdo);
        $this->badgeModel = new BadgeModel($pdo);
        $this->streamModel = new StreamModel($pdo);
    }

    public function index(): void {
        $user = $this->authService->getCurrentUser();
        $profile = $this->profileModel->findByUserId($user['id']);
        $badges = $this->userBadgeModel->findByUser($user['id']);
        $challenges = $this->challengeModel->findActive();
        $recentAttempts = $this->attemptModel->findByUser($user['id']);
        $liveStreams = $this->streamModel->findLive();

        $this->render('dashboard/user/index', [
            'profile' => $profile,
            'badges' => $badges,
            'challenges' => $challenges,
            'recentAttempts' => array_slice($recentAttempts, 0, 5),
            'liveStreams' => array_slice($liveStreams, 0, 6)
        ]);
    }

    public function profile(): void {
        $user = $this->authService->getCurrentUser();
        $profile = $this->profileModel->findByUserId($user['id']);
        $badges = $this->userBadgeModel->findByUser($user['id']);
        $followers = $this->followModel->getFollowers($user['id']);

        $this->render('dashboard/user/profile', [
            'profile' => $profile,
            'badges' => $badges,
            'followers' => $followers
        ]);
    }

    public function updateProfile(): void {
        $user = $this->authService->getCurrentUser();
        $this->profileModel->createOrUpdate($user['id'], [
            'bio' => $_POST['bio'] ?? '',
            'skills' => json_encode(explode(',', $_POST['skills'] ?? '')),
            'social_links' => json_encode([
                'twitter' => $_POST['twitter'] ?? '',
                'instagram' => $_POST['instagram'] ?? '',
                'github' => $_POST['github'] ?? ''
            ])
        ]);
        $this->userModel->update($user['id'], [
            'display_name' => $_POST['display_name'] ?? $user['username'],
            'avatar_url' => $_POST['avatar_url'] ?? $user['avatar_url']
        ]);
        $_SESSION['message'] = 'Profil mis à jour avec succès.';
        header('Location: /dashboard/profile');
        exit;
    }

    public function challenges(): void {
        $user = $this->authService->getCurrentUser();
        $activeChallenges = $this->challengeModel->findActive();
        $attempts = $this->attemptModel->findByUser($user['id']);

        $this->render('dashboard/user/challenges', [
            'activeChallenges' => $activeChallenges,
            'attempts' => $attempts
        ]);
    }

    public function settings(): void {
        $this->render('dashboard/user/settings');
    }

    public function updateSettings(): void {
        $user = $this->authService->getCurrentUser();
        if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            $currentUser = $this->userModel->findById($user['id']);
            if (password_verify($_POST['current_password'], $currentUser['password'])) {
                $this->userModel->updatePassword($user['id'], $_POST['new_password']);
                $_SESSION['message'] = 'Mot de passe mis à jour.';
            } else {
                $_SESSION['error'] = 'Mot de passe actuel incorrect.';
            }
        }
        header('Location: /dashboard/settings');
        exit;
    }

    public function follow(int $userId): void {
        $user = $this->authService->getCurrentUser();
        if ($user['id'] !== $userId) {
            $this->followModel->follow($user['id'], $userId);
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/dashboard'));
        exit;
    }

    public function unfollow(int $userId): void {
        $user = $this->authService->getCurrentUser();
        $this->followModel->unfollow($user['id'], $userId);
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/dashboard'));
        exit;
    }
}
