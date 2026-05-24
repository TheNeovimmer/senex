<?php
namespace Models;
use PDO;

class ReportModel extends BaseModel {
    protected string $table = 'reports';

    public function findByStatus(string $status): array {
        return $this->findWhere('status', $status);
    }

    public function findPending(): array {
        $stmt = $this->pdo->query("SELECT r.*, reporter.username as reporter_name, reported.username as reported_name FROM reports r JOIN users reporter ON r.reporter_id = reporter.id LEFT JOIN users reported ON r.reported_user_id = reported.id WHERE r.status = 'pending' ORDER BY r.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByStatus(string $status): int {
        return $this->count('status', $status);
    }

    public function review(int $reportId, string $status, int $reviewedBy): bool {
        return $this->update($reportId, [
            'status' => $status,
            'reviewed_by' => $reviewedBy
        ]);
    }
}
