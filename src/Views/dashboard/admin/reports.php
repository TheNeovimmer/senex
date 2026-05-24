<?php $title = 'Signalements'; ?>
<div class="section-header">
    <div><h2>Signalements</h2><p>Modération et gestion des signalements</p></div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="dashboard-card mb-4" data-aos="fade-up">
            <div class="card-header"><h5>En attente <span class="nav-badge" style="position:static;display:inline-block;margin-left:8px"><?= count($pendingReports) ?></span></h5></div>
            <div class="card-body">
                <?php if (empty($pendingReports)): ?>
                    <div class="empty-state"><i class="fas fa-check-circle" style="color:#4CAF50"></i><h5>Tout est propre</h5><p style="color:rgba(255,255,255,0.4);font-size:.85rem">Aucun signalement en attente.</p></div>
                <?php else: ?>
                    <?php foreach ($pendingReports as $report): ?>
                        <div class="dashboard-card mb-3" style="border-color:rgba(255,152,0,0.2)">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong style="color:#fff"><?= htmlspecialchars($report['reason']) ?></strong>
                                    <span class="badge" style="background:#FF9800;color:#fff">En attente</span>
                                </div>
                                <p style="color:rgba(255,255,255,0.5);font-size:.85rem">De <strong style="color:#fff"><?= htmlspecialchars($report['reporter_name'] ?? 'Utilisateur #' . $report['reporter_id']) ?></strong> contre <strong style="color:#fff"><?= htmlspecialchars($report['reported_name'] ?? 'Utilisateur #' . $report['reported_user_id']) ?></strong></p>
                                <p style="color:rgba(255,255,255,0.4);font-size:.82rem;margin-bottom:12px"><?= htmlspecialchars(\Core\Helpers::truncate($report['description'] ?? '', 150)) ?></p>
                                <form method="POST" action="/admin/reports/handle/<?= $report['id'] ?>" class="d-flex gap-2" onsubmit="return confirm('Confirmer le traitement?')">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                    <input type="hidden" name="status" value="reviewed">
                                    <button type="submit" class="btn-senex-outline btn-senex-sm" style="border-color:#2196F3;color:#2196F3"><i class="fas fa-check"></i> Examiner</button>
                                    <button type="submit" name="status" value="dismissed" class="btn-senex-outline btn-senex-sm" style="border-color:#666;color:#666"><i class="fas fa-times"></i> Ignorer</button>
                                    <button type="submit" name="status" value="action_taken" class="btn-senex btn-senex-sm btn-senex-danger" onclick="this.form.querySelector('[name=status]').value='action_taken'"><i class="fas fa-ban"></i> Action</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header"><h5>Historique des signalements</h5></div>
            <div class="card-body">
                <?php if (empty($allReports)): ?>
                    <div class="empty-state"><i class="fas fa-flag"></i><h5>Aucun signalement</h5></div>
                <?php else: ?>
                    <table class="table-senex">
                        <thead><tr><th>Raison</th><th>Statut</th><th>Date</th></tr></thead>
                        <tbody>
                            <?php foreach (array_slice($allReports, 0, 20) as $report): ?>
                                <tr>
                                    <td><span style="color:#fff"><?= htmlspecialchars($report['reason']) ?></span></td>
                                    <td><span style="color:<?= $report['status'] === 'pending' ? '#FF9800' : ($report['status'] === 'action_taken' ? '#F44336' : ($report['status'] === 'reviewed' ? '#2196F3' : '#666')) ?>"><?= $report['status'] ?></span></td>
                                    <td style="color:rgba(255,255,255,0.4)"><?= date('d/m/Y', strtotime($report['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
