<?php
namespace Models;
use PDO;

class UserBadgeModel extends BaseModel {
    protected string $table = 'user_badges';

    public function findByUser(int $userId): array {
        $stmt = $this->pdo->prepare("SELECT b.*, ub.earned_at, ub.is_displayed FROM user_badges ub JOIN badges b ON ub.badge_id = b.id WHERE ub.user_id = ? ORDER BY ub.earned_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function awardBadge(int $userId, int $badgeId): bool {
        try {
            return (bool)$this->insert([
                'user_id' => $userId,
                'badge_id' => $badgeId
            ]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function hasBadge(int $userId, int $badgeId): bool {
        return (bool)$this->findOneWhere('user_id', $userId) &&
               $this->findOneWhere('badge_id', $badgeId);
    }

    public function toggleDisplay(int $userBadgeId): bool {
        $badge = $this->findById($userBadgeId);
        if (!$badge) return false;
        return $this->update($userBadgeId, ['is_displayed' => !$badge['is_displayed']]);
    }
}
