<?php
namespace Models;
use PDO;

class NotificationModel extends BaseModel {
    protected string $table = 'notifications';

    public function findByUser(int $userId, int $limit = 20): array {
        $stmt = $this->pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT $limit");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUnread(int $userId): array {
        return $this->findWhere('user_id', $userId);
    }

    public function countUnread(int $userId): int {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = FALSE");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    public function markAsRead(int $notificationId): bool {
        return $this->update($notificationId, ['is_read' => true]);
    }

    public function markAllAsRead(int $userId): bool {
        $stmt = $this->pdo->prepare("UPDATE notifications SET is_read = TRUE WHERE user_id = ?");
        return (bool)$stmt->execute([$userId]);
    }

    public function notify(int $userId, string $type, string $title, string $message = null, string $link = null): int|false {
        return $this->insert([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link
        ]);
    }
}
