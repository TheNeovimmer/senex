<?php
namespace Services;
use PDO;
use Models\NotificationModel;

class NotificationService {
    private NotificationModel $notificationModel;

    public function __construct(PDO $pdo) {
        $this->notificationModel = new NotificationModel($pdo);
    }

    public function send(int $userId, string $type, string $title, ?string $message = null, ?string $link = null): int|false {
        return $this->notificationModel->notify($userId, $type, $title, $message, $link);
    }

    public function getUnread(int $userId, int $limit = 20): array {
        return array_filter($this->notificationModel->findByUser($userId, $limit), fn($n) => !$n['is_read']);
    }

    public function getAll(int $userId, int $limit = 50): array {
        return $this->notificationModel->findByUser($userId, $limit);
    }

    public function markRead(int $notificationId): bool {
        return $this->notificationModel->markAsRead($notificationId);
    }

    public function markAllRead(int $userId): bool {
        return $this->notificationModel->markAllAsRead($userId);
    }

    public function countUnread(int $userId): int {
        return $this->notificationModel->countUnread($userId);
    }
}
