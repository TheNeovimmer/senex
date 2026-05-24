<?php
namespace Models;
use PDO;

class ChatMessageModel extends BaseModel {
    protected string $table = 'chat_messages';

    public function findByStream(int $streamId, int $limit = 50): array {
        $stmt = $this->pdo->prepare("SELECT cm.*, u.username, u.avatar_url FROM chat_messages cm JOIN users u ON cm.user_id = u.id WHERE cm.stream_id = ? ORDER BY cm.created_at DESC LIMIT $limit");
        $stmt->execute([$streamId]);
        return array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function sendMessage(int $streamId, int $userId, string $message): int|false {
        return $this->insert([
            'stream_id' => $streamId,
            'user_id' => $userId,
            'message' => $message
        ]);
    }

    public function moderate(int $messageId): bool {
        return $this->update($messageId, ['is_moderated' => true]);
    }

    public function findFlagged(int $limit = 20): array {
        $stmt = $this->pdo->query("SELECT cm.*, u.username, s.title as stream_title FROM chat_messages cm JOIN users u ON cm.user_id = u.id JOIN streams s ON cm.stream_id = s.id WHERE cm.is_moderated = TRUE ORDER BY cm.created_at DESC LIMIT $limit");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
