<?php
namespace Controllers;
use PDO;
use Services\ChallengeService;

class ResultsController {
    private ChallengeService $challengeService;

    public function __construct(PDO $pdo) {
        $this->challengeService = new ChallengeService($pdo);
    }

    public function leaderboard(int $challengeId): void {
        $entries = $this->challengeService->getLeaderboard($challengeId);
        $title = 'Classement';
        ob_start();
        require __DIR__ . '/../Views/leaderboard.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }
}
