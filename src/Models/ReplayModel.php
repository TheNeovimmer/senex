<?php
namespace Models;
use PDO;

class ReplayModel extends BaseModel {
    protected string $table = 'replays';

    public function findPublished(): array {
        $stmt = $this->pdo->query("SELECT r.*, u.username, u.avatar_url, s.title as stream_title FROM replays r JOIN streams s ON r.stream_id = s.id JOIN users u ON s.user_id = u.id WHERE r.is_published = TRUE ORDER BY r.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByStream(int $streamId): array {
        return $this->findWhere('stream_id', $streamId);
    }

    public function incrementViews(int $id): bool {
        $stmt = $this->pdo->prepare("UPDATE replays SET view_count = view_count + 1 WHERE id = ?");
        return (bool)$stmt->execute([$id]);
    }
}
