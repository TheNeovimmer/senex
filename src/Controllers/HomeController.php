<?php
namespace Controllers;

use PDO;
use Models\StreamModel;
use Models\ChallengeModel;
use Models\ReplayModel;
use Models\UserModel;
use Models\CategoryModel;
use Services\AuthService;
use Services\StreamService;
use Services\ChatService;

class HomeController
{
    private PDO $pdo;
    private StreamModel $streamModel;
    private ChallengeModel $challengeModel;
    private ReplayModel $replayModel;
    private UserModel $userModel;
    private CategoryModel $categoryModel;
    private AuthService $authService;
    private StreamService $streamService;
    private ChatService $chatService;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->streamModel = new StreamModel($pdo);
        $this->challengeModel = new ChallengeModel($pdo);
        $this->replayModel = new ReplayModel($pdo);
        $this->userModel = new UserModel($pdo);
        $this->categoryModel = new CategoryModel($pdo);
        $this->authService = new AuthService($pdo);
        $this->streamService = new StreamService($pdo);
        $this->chatService = new ChatService($pdo);
    }

    public function showhomepage(): void
    {
        $liveStreams = $this->streamModel->findLive();
        $activeChallenges = $this->challengeModel->findActive();
        $userCount = $this->userModel->count();
        $recentReplays = $this->replayModel->findPublished();

        $title = "SENEX - Home";
        ob_start();
        require __DIR__ . '/../Views/home.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }

    public function showStreams(): void
    {
        $liveStreams = $this->streamModel->findLive();
        $upcomingStreams = $this->streamModel->findUpcoming();

        $title = "SENEX - Streams";
        ob_start();
        require __DIR__ . '/../Views/streams.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }

    public function showStreamDetail(int $id): void
    {
        $stream = $this->streamModel->findById($id);
        if (!$stream || $stream['status'] !== 'live') {
            $user = $this->authService->getCurrentUser();
            $streamer = $this->userModel->findById($stream['user_id'] ?? 0);
            $notFound = true;
            $title = 'Stream introuvable';
            ob_start();
            if ($stream) {
                $streamer = $this->userModel->findById($stream['user_id']);
                require __DIR__ . '/../Views/stream_detail.php';
            } else {
                require __DIR__ . '/../Views/stream_detail.php';
            }
            $content = ob_get_clean();
            require __DIR__ . '/../Views/base.php';
            return;
        }
        $streamer = $this->userModel->findById($stream['user_id']);
        $user = $this->authService->getCurrentUser();

        $title = $stream['title'] . ' - SENEX';
        ob_start();
        require __DIR__ . '/../Views/stream_detail.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }

    public function showReplayDetail(int $id): void
    {
        $replay = $this->replayModel->findById($id);
        if (!$replay) {
            header('Location: /replays');
            exit;
        }
        $this->replayModel->incrementViews($id);

        $title = $replay['title'] . ' - SENEX';
        ob_start();
        require __DIR__ . '/../Views/replay_detail.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }
}
