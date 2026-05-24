<?php
namespace Services;
use PDO;
use Models\ReplayModel;
use Models\HighlightModel;

class VideoService {
    private ReplayModel $replayModel;
    private HighlightModel $highlightModel;

    public function __construct(PDO $pdo) {
        $this->replayModel = new ReplayModel($pdo);
        $this->highlightModel = new HighlightModel($pdo);
    }

    public function getReplays(int $page = 1, int $perPage = 12): array {
        return $this->replayModel->paginate($page, $perPage, 'is_published = TRUE');
    }

    public function getReplay(int $id): ?array {
        $replay = $this->replayModel->findById($id);
        if ($replay) $this->replayModel->incrementViews($id);
        return $replay;
    }

    public function getHighlights(int $page = 1, int $perPage = 12): array {
        return $this->highlightModel->paginate($page, $perPage, 'is_published = TRUE');
    }

    public function createReplay(array $data): int|false {
        return $this->replayModel->insert($data);
    }

    public function createHighlight(array $data): int|false {
        return $this->highlightModel->insert($data);
    }

    public function updateReplay(int $id, array $data): bool {
        return $this->replayModel->update($id, $data);
    }

    public function updateHighlight(int $id, array $data): bool {
        return $this->highlightModel->update($id, $data);
    }

    public function deleteReplay(int $id): bool {
        return $this->replayModel->delete($id);
    }

    public function deleteHighlight(int $id): bool {
        return $this->highlightModel->delete($id);
    }
}
