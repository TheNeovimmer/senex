<?php
namespace Models;
use PDO;

class HighlightModel extends BaseModel {
    protected string $table = 'highlights';

    public function findByStream(int $streamId): array {
        return $this->findWhere('stream_id', $streamId);
    }

    public function findPublished(): array {
        $stmt = $this->pdo->query("SELECT h.*, u.username, s.title as stream_title FROM highlights h JOIN streams s ON h.stream_id = s.id JOIN users u ON s.user_id = u.id WHERE h.is_published = TRUE ORDER BY h.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByAiGenerated(): array {
        return $this->findWhere('is_ai_generated', true);
    }

    public function incrementViews(int $id): bool {
        $stmt = $this->pdo->prepare("UPDATE highlights SET view_count = view_count + 1 WHERE id = ?");
        return (bool)$stmt->execute([$id]);
    }
}
