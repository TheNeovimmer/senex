<?php
namespace Models;
use PDO;

class UserProfileModel extends BaseModel {
    protected string $table = 'user_profiles';

    public function findByUserId(int $userId): ?array {
        return $this->findOneWhere('user_id', $userId);
    }

    public function createOrUpdate(int $userId, array $data): bool {
        $existing = $this->findByUserId($userId);
        if ($existing) {
            return $this->update($existing['id'], $data);
        }
        $data['user_id'] = $userId;
        return (bool)$this->insert($data);
    }

    public function addXp(int $userId, int $xp): bool {
        $profile = $this->findByUserId($userId);
        if (!$profile) return false;
        $newXp = $profile['experience_points'] + $xp;
        $newLevel = $this->calculateLevel($newXp);
        return $this->update($profile['id'], [
            'experience_points' => $newXp,
            'level' => $newLevel
        ]);
    }

    private function calculateLevel(int $xp): int {
        return max(1, (int)floor(1 + $xp / 500));
    }

    public function getLeaderboard(int $limit = 20): array {
        $stmt = $this->pdo->query("SELECT up.*, u.username, u.avatar_url FROM user_profiles up JOIN users u ON up.user_id = u.id ORDER BY up.experience_points DESC LIMIT $limit");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
