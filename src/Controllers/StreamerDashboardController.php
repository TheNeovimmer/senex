<?php
namespace Controllers;
use PDO;
use Services\StreamService;
use Services\ChallengeService;
use Services\ChatService;
use Models\StreamModel;
use Models\ChallengeModel;
use Models\CategoryModel;
use Models\ReplayModel;
use Models\HighlightModel;

class StreamerDashboardController extends DashboardController {
    private StreamService $streamService;
    private ChallengeService $challengeService;
    private ChatService $chatService;
    private StreamModel $streamModel;
    private ChallengeModel $challengeModel;
    private CategoryModel $categoryModel;
    private ReplayModel $replayModel;
    private HighlightModel $highlightModel;

    public function __construct(PDO $pdo) {
        parent::__construct($pdo);
        $this->streamService = new StreamService($pdo);
        $this->challengeService = new ChallengeService($pdo);
        $this->chatService = new ChatService($pdo);
        $this->streamModel = new StreamModel($pdo);
        $this->challengeModel = new ChallengeModel($pdo);
        $this->categoryModel = new CategoryModel($pdo);
        $this->replayModel = new ReplayModel($pdo);
        $this->highlightModel = new HighlightModel($pdo);
    }

    public function index(): void {
        $user = $this->authService->getCurrentUser();
        $streams = $this->streamModel->findByUser($user['id']);
        $challenges = $this->challengeModel->findByUser($user['id']);
        $liveStream = $this->getCurrentLiveStream($user['id']);
        $totalViews = array_sum(array_column($streams, 'viewer_count'));
        $totalStreams = count($streams);

        $this->render('dashboard/streamer/index', [
            'streams' => $streams,
            'challenges' => $challenges,
            'liveStream' => $liveStream,
            'totalViews' => $totalViews,
            'totalStreams' => $totalStreams,
            'categories' => $this->categoryModel->findActive()
        ]);
    }

    public function createStream(): void {
        $user = $this->authService->getCurrentUser();
        if (!$this->authService->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Session invalide.';
            header('Location: /streamer/streams');
            exit;
        }
        $streamId = $this->streamService->createStream($user['id'], [
            'title' => $_POST['title'] ?? 'Nouveau stream',
            'description' => $_POST['description'] ?? '',
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'thumbnail_url' => $_POST['thumbnail_url'] ?? null,
            'scheduled_at' => !empty($_POST['scheduled_at']) ? $_POST['scheduled_at'] : null
        ]);

        if ($streamId) {
            $_SESSION['message'] = 'Stream créé avec succès!';
            $_SESSION['last_stream_id'] = $streamId;
        } else {
            $_SESSION['error'] = 'Erreur lors de la création du stream.';
        }
        header('Location: /streamer/streams');
        exit;
    }

    public function goLive(int $streamId): void {
        $this->streamService->startStream($streamId);
        header("Location: /streamer/live/$streamId");
        exit;
    }

    public function endLive(int $streamId): void {
        $this->streamService->endStream($streamId);
        $this->streamService->generateReplay($streamId, 'Replay - ' . date('d/m/Y H:i'));
        $_SESSION['message'] = 'Stream terminé. Un replay a été généré.';
        header('Location: /streamer/streams');
        exit;
    }

    public function liveView(int $streamId): void {
        $user = $this->authService->getCurrentUser();
        $stream = $this->streamModel->findById($streamId);
        if (!$stream || $stream['user_id'] !== $user['id']) {
            header('Location: /streamer');
            exit;
        }
        $activeChallenge = $this->challengeService->getActiveStreamChallenge($streamId);
        $userChallenges = $this->challengeModel->findByUser($user['id']);
        $this->render('dashboard/streamer/live', [
            'stream' => $stream,
            'activeChallenge' => $activeChallenge,
            'userChallenges' => $userChallenges
        ]);
    }

    public function streams(): void {
        $user = $this->authService->getCurrentUser();
        $streams = $this->streamModel->findByUser($user['id']);
        $this->render('dashboard/streamer/streams', [
            'streams' => $streams,
            'categories' => $this->categoryModel->findActive()
        ]);
    }

    public function challenges(): void {
        $user = $this->authService->getCurrentUser();
        $challenges = $this->challengeModel->findByUser($user['id']);
        $this->render('dashboard/streamer/challenges', [
            'challenges' => $challenges,
            'categories' => $this->categoryModel->findByType('challenge')
        ]);
    }

    public function createChallenge(): void {
        $user = $this->authService->getCurrentUser();
        if (!$this->authService->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Session invalide.';
            header('Location: /streamer/challenges');
            exit;
        }
        $challengeId = $this->challengeService->createChallenge($user['id'], [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'rules' => $_POST['rules'] ?? '',
            'difficulty' => $_POST['difficulty'] ?? 'medium',
            'type' => $_POST['type'] ?? 'solo',
            'duration_seconds' => (int)($_POST['duration_seconds'] ?? 60),
            'xp_reward' => (int)($_POST['xp_reward'] ?? 100),
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'objectives' => json_encode(explode("\n", $_POST['objectives'] ?? '')),
            'status' => 'draft'
        ]);

        if ($challengeId) {
            $_SESSION['message'] = 'Défi créé avec succès!';
        } else {
            $_SESSION['error'] = 'Erreur lors de la création du défi.';
        }
        header('Location: /streamer/challenges');
        exit;
    }

    public function activateChallenge(int $challengeId): void {
        $this->challengeService->activateChallenge($challengeId);
        header('Location: /streamer/challenges');
        exit;
    }

    public function startChallengeOnStream(int $streamId, int $challengeId): void {
        $this->challengeService->activateOnStream($streamId, $challengeId);
        header("Location: /streamer/live/$streamId");
        exit;
    }

    public function stopChallengeOnStream(int $streamId): void {
        $this->challengeService->deactivateOnStream($streamId);
        $_SESSION['message'] = 'Défi arrêté.';
        header("Location: /streamer/live/$streamId");
        exit;
    }

    public function replays(): void {
        $user = $this->authService->getCurrentUser();
        $streams = $this->streamModel->findByUser($user['id']);
        $allReplays = [];
        foreach ($streams as $s) {
            $replays = $this->replayModel->findByStream($s['id']);
            foreach ($replays as $r) {
                $r['stream_title'] = $s['title'];
                $allReplays[] = $r;
            }
        }
        $this->render('dashboard/streamer/replays', ['replays' => $allReplays]);
    }

    public function highlights(): void {
        $user = $this->authService->getCurrentUser();
        $streams = $this->streamModel->findByUser($user['id']);
        $allHighlights = [];
        foreach ($streams as $s) {
            $highlights = $this->highlightModel->findByStream($s['id']);
            foreach ($highlights as $h) {
                $h['stream_title'] = $s['title'];
                $allHighlights[] = $h;
            }
        }
        $this->render('dashboard/streamer/highlights', ['highlights' => $allHighlights]);
    }

    private function getCurrentLiveStream(int $userId): ?array {
        $streams = $this->streamModel->findByUser($userId);
        foreach ($streams as $s) {
            if ($s['status'] === 'live') return $s;
        }
        return null;
    }
}
