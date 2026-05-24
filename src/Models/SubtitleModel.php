<?php
namespace Models;
use PDO;

class SubtitleModel extends BaseModel {
    protected string $table = 'subtitles';

    public function findByStream(int $streamId): array {
        return $this->findWhere('stream_id', $streamId);
    }

    public function findByStreamAndLang(int $streamId, string $lang): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM subtitles WHERE stream_id = ? AND language = ? LIMIT 1");
        $stmt->execute([$streamId, $lang]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getLanguages(int $streamId): array {
        $stmt = $this->pdo->prepare("SELECT DISTINCT language FROM subtitles WHERE stream_id = ?");
        $stmt->execute([$streamId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
