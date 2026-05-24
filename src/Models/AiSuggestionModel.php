<?php
namespace Models;
use PDO;

class AiSuggestionModel extends BaseModel {
    protected string $table = 'ai_suggestions';

    public function findByType(string $type): array {
        return $this->findWhere('type', $type);
    }

    public function findPending(): array {
        return $this->findWhere('status', 'pending');
    }

    public function findByUser(int $userId): array {
        return $this->findWhere('target_user_id', $userId);
    }

    public function approve(int $id): bool {
        return $this->update($id, ['status' => 'approved']);
    }

    public function reject(int $id): bool {
        return $this->update($id, ['status' => 'rejected']);
    }
}
