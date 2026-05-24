<?php
namespace Models;
use PDO;

class StreamChallengeModel extends BaseModel {
    protected string $table = 'stream_challenges';

    public function findByStream(int $streamId): array {
        return $this->findWhere('stream_id', $streamId);
    }

    public function getActiveForStream(int $streamId): ?array {
        $stmt = $this->pdo->prepare("SELECT sc.*, c.title, c.description, c.type, c.difficulty, c.duration_seconds, c.rules, c.objectives FROM stream_challenges sc JOIN challenges c ON sc.challenge_id = c.id WHERE sc.stream_id = ? AND sc.is_active = TRUE LIMIT 1");
        $stmt->execute([$streamId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function startChallenge(int $streamId, int $challengeId): bool {
        $this->pdo->prepare("UPDATE stream_challenges SET is_active = FALSE WHERE stream_id = ?")->execute([$streamId]);
        return (bool)$this->insert([
            'stream_id' => $streamId,
            'challenge_id' => $challengeId,
            'is_active' => true,
            'started_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function endChallenge(int $streamId): bool {
        $active = $this->getActiveForStream($streamId);
        if (!$active) return false;
        return $this->update($active['id'], [
            'is_active' => false,
            'ended_at' => date('Y-m-d H:i:s')
        ]);
    }
}
