<?php
namespace Services;
use PDO;
use Models\ReportModel;
use Models\UserModel;
use Models\NotificationModel;

class ModerationService {
    private ReportModel $reportModel;
    private UserModel $userModel;
    private NotificationModel $notificationModel;

    public function __construct(PDO $pdo) {
        $this->reportModel = new ReportModel($pdo);
        $this->userModel = new UserModel($pdo);
        $this->notificationModel = new NotificationModel($pdo);
    }

    public function submitReport(int $reporterId, array $data): int|false {
        $data['reporter_id'] = $reporterId;
        return $this->reportModel->insert($data);
    }

    public function reviewReport(int $reportId, string $status, int $reviewedBy): bool {
        $result = $this->reportModel->review($reportId, $status, $reviewedBy);
        if ($result) {
            $report = $this->reportModel->findById($reportId);
            if ($report && $report['reported_user_id']) {
                $this->notificationModel->notify(
                    $report['reported_user_id'],
                    'moderation',
                    'Signalement traité',
                    'Votre contenu a été examiné par notre équipe de modération.'
                );
            }
        }
        return $result;
    }

    public function suspendUser(int $userId, int $adminId): bool {
        $user = $this->userModel->findById($userId);
        if (!$user) return false;
        $result = $this->userModel->update($userId, ['is_active' => false]);
        if ($result) {
            $this->notificationModel->notify(
                $userId,
                'suspension',
                'Compte suspendu',
                'Votre compte a été suspendu. Contactez le support pour plus d\'informations.'
            );
        }
        return $result;
    }

    public function unsuspendUser(int $userId): bool {
        return $this->userModel->update($userId, ['is_active' => true]);
    }

    public function getPendingReports(): array {
        return $this->reportModel->findPending();
    }

    public function getReportStats(): array {
        return [
            'pending' => $this->reportModel->countByStatus('pending'),
            'reviewed' => $this->reportModel->countByStatus('reviewed'),
            'dismissed' => $this->reportModel->countByStatus('dismissed'),
            'action_taken' => $this->reportModel->countByStatus('action_taken'),
            'total' => $this->reportModel->count()
        ];
    }
}
