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
            $this->userModel->update($userId, ['is_active' => !($user['is_active'] ?? true)]);
        }
        header('Location: /admin/users');
        exit;
    }

    public function streams(): void {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $streams = $this->streamModel->paginate($page, 20);
        $this->render('dashboard/admin/streams', ['streamsData' => $streams]);
    }

    public function challenges(): void {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $challenges = $this->challengeModel->paginate($page, 20);
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
        $status = $_POST['status'] ?? 'reviewed';
        $admin = $this->authService->getCurrentUser();
        $this->moderationService->reviewReport($reportId, $status, $admin['id']);
        if ($status === 'action_taken' && !empty($_POST['suspend_user'])) {
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

    public function deleteCategory(int $id): void {
        $this->categoryModel->delete($id);
        header('Location: /admin/categories');
        exit;
    }

    public function badges(): void {
        $badges = $this->badgeModel->findAll('name ASC');
        $this->render('dashboard/admin/badges', ['badges' => $badges]);
    }

    public function createBadge(): void {
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

    public function deleteBadge(int $id): void {
        $this->badgeModel->delete($id);
        header('Location: /admin/badges');
        exit;
    }

    public function aiSettings(): void {
        $suggestions = $this->pdo->query("SELECT * FROM ai_suggestions ORDER BY created_at DESC LIMIT 20")->fetchAll(\PDO::FETCH_ASSOC);
        $this->render('dashboard/admin/ai', ['suggestions' => $suggestions]);
    }

    public function generateSuggestion(): void {
        $this->aiService->generateChallengeSuggestion(0, $_POST);
        $_SESSION['message'] = 'Suggestion AI générée.';
        header('Location: /admin/ai');
        exit;
    }
}
