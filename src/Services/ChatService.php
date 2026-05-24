<?php
namespace Services;
use PDO;
use Models\ChatMessageModel;

class ChatService {
    private ChatMessageModel $chatModel;

    public function __construct(PDO $pdo) {
        $this->chatModel = new ChatMessageModel($pdo);
    }

    public function send(int $streamId, int $userId, string $message): int|false {
        return $this->chatModel->sendMessage($streamId, $userId, $message);
    }

    public function getMessages(int $streamId, int $limit = 50): array {
        return $this->chatModel->findByStream($streamId, $limit);
    }

    public function moderate(int $messageId): bool {
        return $this->chatModel->moderate($messageId);
    }

    public function getFlaggedMessages(int $limit = 20): array {
        return $this->chatModel->findFlagged($limit);
    }
}
