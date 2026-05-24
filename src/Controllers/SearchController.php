<?php
namespace Controllers;
use PDO;
use Models\UserModel;
use Models\StreamModel;
use Models\ChallengeModel;

class SearchController {
    private PDO $pdo;
    private UserModel $userModel;
    private StreamModel $streamModel;
    private ChallengeModel $challengeModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->userModel = new UserModel($pdo);
        $this->streamModel = new StreamModel($pdo);
        $this->challengeModel = new ChallengeModel($pdo);
    }

    public function search(): void {
        $query = trim($_GET['q'] ?? '');
        $users = [];
        $streams = [];
        $challenges = [];

        if (strlen($query) >= 2) {
            $users = $this->userModel->search($query);
            $streams = $this->streamModel->search($query);
            $challenges = $this->challengeModel->search($query);
        }

        $title = 'Recherche';
        ob_start();
        require __DIR__ . '/../Views/search.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }
}
