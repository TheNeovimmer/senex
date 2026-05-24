<?php
namespace Controllers;
use PDO;
use Services\ModerationService;
use Services\AIService;
use Models\UserModel;
use Models\StreamModel;
use Models\ChallengeModel;
use Models\ReportModel;
use Models\CategoryModel;
use Models\BadgeModel;
use Models\UserBadgeModel;

class AdminDashboardController extends DashboardController {
    private ModerationService $moderationService;
    private AIService $aiService;
    private StreamModel $streamModel;
    private ChallengeModel $challengeModel;
    private ReportModel $reportModel;
    private CategoryModel $categoryModel;
    private BadgeModel $badgeModel;
    private UserBadgeModel $userBadgeModel;

    public function __construct(PDO $pdo) {
        parent::__construct($pdo);
        $this->moderationService = new ModerationService($pdo);
        $this->aiService = new AIService($pdo);
        $this->userModel = new UserModel($pdo);
        $this->streamModel = new StreamModel($pdo);
        $this->challengeModel = new ChallengeModel($pdo);
        $this->reportModel = new ReportModel($pdo);
        $this->categoryModel = new CategoryModel($pdo);
        $this->badgeModel = new BadgeModel($pdo);
        $this->userBadgeModel = new UserBadgeModel($pdo);
    }

    public function index(): void {
        $userCount = $this->userModel->count();
        $streamCount = $this->streamModel->count();
        $challengeCount = $this->challengeModel->count();
        $reportCount = $this->reportModel->count();
        $liveCount = count($this->streamModel->findLive());
        $pendingReports = count($this->reportModel->findPending());
        $recentUsers = $this->userModel->findAll('created_at DESC', 10);
        $reportStats = $this->moderationService->getReportStats();

        $this->render('dashboard/admin/index', [
            'userCount' => $userCount,
            'streamCount' => $streamCount,
            'challengeCount' => $challengeCount,
            'reportCount' => $reportCount,
            'liveCount' => $liveCount,
            'pendingReports' => $pendingReports,
            'recentUsers' => $recentUsers,
            'reportStats' => $reportStats
        ]);
    }

    public function users(): void {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $users = $this->userModel->paginate($page, 20);
        $this->render('dashboard/admin/users', ['usersData' => $users]);
    }

    public function searchUsers(): void {
        $query = $_GET['q'] ?? '';
        $users = $this->userModel->search($query);
        $this->render('dashboard/admin/users', [
            'usersData' => ['items' => $users, 'total' => count($users), 'page' => 1, 'lastPage' => 1],
            'searchQuery' => $query
        ]);
    }

    public function toggleUserStatus(int $userId): void {
        $user = $this->userModel->findById($userId);
        if ($user) {
            $isActive = isset($user['is_active']) ? (bool)$user['is_active'] : true;
            $this->userModel->update($userId, ['is_active' => !$isActive]);
        }
        header('Location: /admin/users');
        exit;
    }

    public function streams(): void {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
        $total = $this->pdo->query("SELECT COUNT(*) FROM streams")->fetchColumn();
        $stmt = $this->pdo->prepare("SELECT s.*, u.username as streamer_name, c.name as category_name FROM streams s LEFT JOIN users u ON s.user_id = u.id LEFT JOIN categories c ON s.category_id = c.id ORDER BY s.created_at DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute();
        $streams = [
            'items' => $stmt->fetchAll(\PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'lastPage' => max(1, (int)ceil($total / $perPage))
        ];
        $this->render('dashboard/admin/streams', ['streamsData' => $streams]);
    }

    public function challenges(): void {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
        $total = $this->pdo->query("SELECT COUNT(*) FROM challenges")->fetchColumn();
        $stmt = $this->pdo->prepare("SELECT ch.*, u.username as creator_name FROM challenges ch LEFT JOIN users u ON ch.user_id = u.id ORDER BY ch.created_at DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute();
        $challenges = [
            'items' => $stmt->fetchAll(\PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'lastPage' => max(1, (int)ceil($total / $perPage))
        ];
        $this->render('dashboard/admin/challenges', ['challengesData' => $challenges]);
    }

    public function reports(): void {
        $reports = $this->reportModel->findPending();
        $allReports = $this->reportModel->findAll('created_at DESC');
        $this->render('dashboard/admin/reports', [
            'pendingReports' => $reports,
            'allReports' => $allReports
        ]);
    }

    public function handleReport(int $reportId): void {
        if (!$this->authService->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Session invalide.';
            header('Location: /admin/reports');
            exit;
        }
        $status = $_POST['status'] ?? 'reviewed';
        $admin = $this->authService->getCurrentUser();
        $this->moderationService->reviewReport($reportId, $status, $admin['id']);
        if ($status === 'action_taken') {
            $report = $this->reportModel->findById($reportId);
            if ($report && $report['reported_user_id']) {
                $this->moderationService->suspendUser((int)$report['reported_user_id'], $admin['id']);
            }
        }
        $_SESSION['message'] = 'Signalement traité.';
        header('Location: /admin/reports');
        exit;
    }

    public function categories(): void {
        $categories = $this->categoryModel->findAll('name ASC');
        $this->render('dashboard/admin/categories', ['categories' => $categories]);
    }

    public function createCategory(): void {
        if (!$this->authService->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Session invalide.';
            header('Location: /admin/categories');
            exit;
        }
        $this->categoryModel->insert([
            'name' => $_POST['name'] ?? '',
            'slug' => \Core\Helpers::slugify($_POST['name'] ?? ''),
            'type' => $_POST['type'] ?? 'both',
            'icon' => $_POST['icon'] ?? null,
            'color' => $_POST['color'] ?? '#F15BB5',
            'description' => $_POST['description'] ?? null
        ]);
        $_SESSION['message'] = 'Catégorie créée.';
        header('Location: /admin/categories');
        exit;
    }

    public function badges(): void {
        $badges = $this->badgeModel->findAll('name ASC');
        $this->render('dashboard/admin/badges', ['badges' => $badges]);
    }

    public function createBadge(): void {
        if (!$this->authService->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Session invalide.';
            header('Location: /admin/badges');
            exit;
        }
        $this->badgeModel->insert([
            'name' => $_POST['name'] ?? '',
            'slug' => \Core\Helpers::slugify($_POST['name'] ?? ''),
            'description' => $_POST['description'] ?? null,
            'criteria_type' => $_POST['criteria_type'] ?? 'special',
            'criteria_value' => (int)($_POST['criteria_value'] ?? 0),
            'xp_reward' => (int)($_POST['xp_reward'] ?? 0),
            'color' => $_POST['color'] ?? '#F15BB5'
        ]);
        $_SESSION['message'] = 'Badge créé.';
        header('Location: /admin/badges');
        exit;
    }

    public function aiSettings(): void {
        $suggestions = $this->pdo->query("SELECT * FROM ai_suggestions ORDER BY created_at DESC LIMIT 20")->fetchAll(\PDO::FETCH_ASSOC);
        $this->render('dashboard/admin/ai', ['suggestions' => $suggestions]);
    }

    public function generateSuggestion(): void {
        if (!$this->authService->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Session invalide.';
            header('Location: /admin/ai');
            exit;
        }
        $this->aiService->generateChallengeSuggestion(0, $_POST);
        $_SESSION['message'] = 'Suggestion AI générée.';
        header('Location: /admin/ai');
        exit;
    }

    public function deleteCategory(int $id): void {
        if (!$this->authService->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Session invalide.';
            header('Location: /admin/categories');
            exit;
        }
        $this->categoryModel->delete($id);
        $_SESSION['message'] = 'Catégorie supprimée.';
        header('Location: /admin/categories');
        exit;
    }

    public function deleteBadge(int $id): void {
        if (!$this->authService->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Session invalide.';
            header('Location: /admin/badges');
            exit;
        }
        $this->badgeModel->delete($id);
        $_SESSION['message'] = 'Badge supprimé.';
        header('Location: /admin/badges');
        exit;
    }
}
