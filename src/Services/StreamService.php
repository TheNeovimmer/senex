<?php
namespace Services;
use PDO;
use Models\StreamModel;
use Models\ReplayModel;
use Models\NotificationModel;

class StreamService {
    private StreamModel $streamModel;
    private ReplayModel $replayModel;
    private NotificationModel $notificationModel;

    public function __construct(PDO $pdo) {
        $this->streamModel = new StreamModel($pdo);
        $this->replayModel = new ReplayModel($pdo);
        $this->notificationModel = new NotificationModel($pdo);
    }

    public function createStream(int $userId, array $data): int|false {
        $data['user_id'] = $userId;
        $data['stream_key'] = $this->streamModel->generateStreamKey();
        $data['status'] = 'scheduled';
        return $this->streamModel->insert($data);
    }

    public function startStream(int $streamId): bool {
        return $this->streamModel->update($streamId, [
            'status' => 'live',
            'started_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function endStream(int $streamId): bool {
        $stream = $this->streamModel->findById($streamId);
        if (!$stream) return false;
        $started = new \DateTime($stream['started_at']);
        $now = new \DateTime();
        $duration = $now->getTimestamp() - $started->getTimestamp();
        return $this->streamModel->update($streamId, [
            'status' => 'ended',
            'ended_at' => $now->format('Y-m-d H:i:s'),
            'duration_seconds' => max(0, $duration)
        ]);
    }

    public function getLiveStreams(): array {
        return $this->streamModel->findLive();
    }

    public function getStreamWithUser(int $streamId): ?array {
        $stream = $this->streamModel->findById($streamId);
        if (!$stream) return null;
        return $stream;
    }

    public function generateReplay(int $streamId, string $title): int|false {
        $stream = $this->streamModel->findById($streamId);
        if (!$stream) return false;
        $replayId = $this->replayModel->insert([
            'stream_id' => $streamId,
            'title' => $title,
            'duration_seconds' => $stream['duration_seconds'],
            'thumbnail_url' => $stream['thumbnail_url']
        ]);
        if ($replayId) {
            $this->streamModel->update($streamId, ['has_replay' => true]);
        }
        return $replayId;
    }

    public function notifyFollowers(int $streamId): void {
        $stream = $this->streamModel->findById($streamId);
        if (!$stream) return;
    }
}
