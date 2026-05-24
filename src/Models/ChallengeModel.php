<?php
namespace Models;
use PDO;

class ChallengeModel extends BaseModel {
    protected string $table = 'challenges';

    public function findByStatus(string $status): array {
        return $this->findWhere('status', $status);
    }

    public function findActive(): array {
        $stmt = $this->pdo->query("SELECT c.*, u.username, u.avatar_url FROM challenges c JOIN users u ON c.user_id = u.id WHERE c.status = 'active' ORDER BY c.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findFeatured(): array {
        $stmt = $this->pdo->query("SELECT c.*, u.username FROM challenges c JOIN users u ON c.user_id = u.id WHERE c.is_featured = TRUE AND c.status = 'active' LIMIT 6");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser(int $userId): array {
        return $this->findWhere('user_id', $userId);
    }

    public function findByCategory(int $categoryId): array {
        $stmt = $this->pdo->prepare("SELECT c.*, u.username FROM challenges c JOIN users u ON c.user_id = u.id WHERE c.category_id = ? AND c.status = 'active'");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByStatus(string $status): int {
        return $this->count('status', $status);
    }

    public function search(string $query): array {
        $stmt = $this->pdo->prepare("SELECT c.*, u.username FROM challenges c JOIN users u ON c.user_id = u.id WHERE c.title LIKE ? AND c.status = 'active' LIMIT 20");
        $like = "%$query%";
        $stmt->execute([$like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
