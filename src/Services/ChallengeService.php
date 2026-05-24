<?php
namespace Services;
use PDO;
use Models\ChallengeModel;
use Models\ChallengeAttemptModel;
use Models\StreamChallengeModel;
use Models\UserProfileModel;

class ChallengeService {
    private ChallengeModel $challengeModel;
    private ChallengeAttemptModel $attemptModel;
    private StreamChallengeModel $streamChallengeModel;
    private UserProfileModel $profileModel;

    public function __construct(PDO $pdo) {
        $this->challengeModel = new ChallengeModel($pdo);
        $this->attemptModel = new ChallengeAttemptModel($pdo);
        $this->streamChallengeModel = new StreamChallengeModel($pdo);
        $this->profileModel = new UserProfileModel($pdo);
    }

    public function createChallenge(int $userId, array $data): int|false {
        $data['user_id'] = $userId;
        return $this->challengeModel->insert($data);
    }

    public function activateChallenge(int $challengeId): bool {
        return $this->challengeModel->update($challengeId, ['status' => 'active']);
    }

    public function completeChallenge(int $challengeId): bool {
        return $this->challengeModel->update($challengeId, ['status' => 'completed']);
    }

    public function activateOnStream(int $streamId, int $challengeId): bool {
        return (bool)$this->streamChallengeModel->startChallenge($streamId, $challengeId);
    }

    public function deactivateOnStream(int $streamId): bool {
        return $this->streamChallengeModel->endChallenge($streamId);
    }

    public function getActiveStreamChallenge(int $streamId): ?array {
        return $this->streamChallengeModel->getActiveForStream($streamId);
    }

    public function submitAttempt(int $userId, int $challengeId, int $score, int $timeTaken, array $details = []): int|false {
        return $this->attemptModel->insert([
            'user_id' => $userId,
            'challenge_id' => $challengeId,
            'score' => $score,
            'completed' => true,
            'time_taken_seconds' => $timeTaken,
            'details' => json_encode($details),
            'ended_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function awardXp(int $userId, int $challengeId): bool {
        $challenge = $this->challengeModel->findById($challengeId);
        if (!$challenge) return false;
        return $this->profileModel->addXp($userId, $challenge['xp_reward']);
    }

    public function getActiveChallenges(): array {
        return $this->challengeModel->findActive();
    }

    public function getLeaderboard(int $challengeId, int $limit = 20): array {
        $stmt = $this->challengeModel->pdo->prepare("
            SELECT ca.*, u.username, u.avatar_url FROM challenge_attempts ca 
            JOIN users u ON ca.user_id = u.id 
            WHERE ca.challenge_id = ? AND ca.completed = TRUE 
            ORDER BY ca.score DESC LIMIT $limit
        ");
        $stmt->execute([$challengeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
