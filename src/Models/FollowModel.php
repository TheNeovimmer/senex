<?php
namespace Models;
use PDO;

class FollowModel extends BaseModel {
    protected string $table = 'follows';

    public function isFollowing(int $followerId, int $followingId): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM follows WHERE follower_id = ? AND following_id = ?");
        $stmt->execute([$followerId, $followingId]);
        return (bool)$stmt->fetchColumn();
    }

    public function follow(int $followerId, int $followingId): bool {
        try {
            return (bool)$this->insert([
                'follower_id' => $followerId,
                'following_id' => $followingId
            ]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function unfollow(int $followerId, int $followingId): bool {
        $stmt = $this->pdo->prepare("DELETE FROM follows WHERE follower_id = ? AND following_id = ?");
        return (bool)$stmt->execute([$followerId, $followingId]);
    }

    public function getFollowers(int $userId): array {
        $stmt = $this->pdo->prepare("SELECT u.id, u.username, u.avatar_url, f.created_at FROM follows f JOIN users u ON f.follower_id = u.id WHERE f.following_id = ? ORDER BY f.created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFollowing(int $userId): array {
        $stmt = $this->pdo->prepare("SELECT u.id, u.username, u.avatar_url, f.created_at FROM follows f JOIN users u ON f.following_id = u.id WHERE f.follower_id = ? ORDER BY f.created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countFollowers(int $userId): int {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM follows WHERE following_id = ?");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    public function countFollowing(int $userId): int {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM follows WHERE follower_id = ?");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
}
