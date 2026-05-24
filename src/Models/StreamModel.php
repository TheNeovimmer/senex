<?php
namespace Models;
use PDO;

class StreamModel extends BaseModel {
    protected string $table = 'streams';

    public function findByStatus(string $status): array {
        return $this->findWhere('status', $status);
    }

    public function findLive(): array {
        $stmt = $this->pdo->query("SELECT s.*, u.username, u.avatar_url, c.name as category_name FROM streams s JOIN users u ON s.user_id = u.id LEFT JOIN categories c ON s.category_id = c.id WHERE s.status = 'live' ORDER BY s.viewer_count DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUpcoming(): array {
        $stmt = $this->pdo->query("SELECT s.*, u.username, u.avatar_url FROM streams s JOIN users u ON s.user_id = u.id WHERE s.status = 'scheduled' AND s.scheduled_at > NOW() ORDER BY s.scheduled_at ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser(int $userId): array {
        return $this->findWhere('user_id', $userId);
    }

    public function findByStreamKey(string $streamKey): ?array {
        return $this->findOneWhere('stream_key', $streamKey);
    }

    public function updateViewerCount(int $id, int $count): bool {
        return $this->update($id, ['viewer_count' => $count]);
    }

    public function generateStreamKey(): string {
        return bin2hex(random_bytes(16));
    }

    public function findFeatured(): array {
        $stmt = $this->pdo->query("SELECT s.*, u.username, u.avatar_url FROM streams s JOIN users u ON s.user_id = u.id WHERE s.is_featured = TRUE AND s.status = 'live' LIMIT 6");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search(string $query): array {
        $stmt = $this->pdo->prepare("SELECT s.*, u.username FROM streams s JOIN users u ON s.user_id = u.id WHERE s.title LIKE ? AND s.status = 'live' LIMIT 20");
        $like = "%$query%";
        $stmt->execute([$like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
