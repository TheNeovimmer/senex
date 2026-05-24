<?php
namespace Models;
use PDO;

class ChallengeAttemptModel extends BaseModel {
    protected string $table = 'challenge_attempts';

    public function findByUser(int $userId): array {
        return $this->findWhere('user_id', $userId);
    }

    public function findByChallenge(int $challengeId): array {
        return $this->findWhere('challenge_id', $challengeId);
    }

    public function findByStream(int $streamId): array {
        return $this->findWhere('stream_id', $streamId);
    }

    public function getUserBestScore(int $userId, int $challengeId): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM challenge_attempts WHERE user_id = ? AND challenge_id = ? ORDER BY score DESC LIMIT 1");
        $stmt->execute([$userId, $challengeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getActiveAttempt(int $userId, int $challengeId): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM challenge_attempts WHERE user_id = ? AND challenge_id = ? AND completed = FALSE ORDER BY started_at DESC LIMIT 1");
        $stmt->execute([$userId, $challengeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function countCompletedByUser(int $userId): int {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM challenge_attempts WHERE user_id = ? AND completed = TRUE");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
}
