<?php $title = 'Admin Dashboard'; ?>
<div class="section-header">
    <div><h2>Administration</h2><p>Gérez la plateforme SENEX</p></div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card" data-aos="fade-up">
            <div class="stat-icon stat-icon-pink"><i class="fas fa-users"></i></div>
            <div class="stat-value"><?= \Core\Helpers::formatNumber($userCount) ?></div>
            <div class="stat-label">Utilisateurs</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="50">
            <div class="stat-icon stat-icon-purple"><i class="fas fa-video"></i></div>
            <div class="stat-value"><?= \Core\Helpers::formatNumber($streamCount) ?></div>
            <div class="stat-label">Streams</div>
            <div class="stat-change up"><i class="fas fa-circle text-danger me-1"></i><?= $liveCount ?> en direct</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-icon stat-icon-blue"><i class="fas fa-trophy"></i></div>
            <div class="stat-value"><?= \Core\Helpers::formatNumber($challengeCount) ?></div>
            <div class="stat-label">Défis</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="150">
            <div class="stat-icon stat-icon-red"><i class="fas fa-flag"></i></div>
            <div class="stat-value"><?= \Core\Helpers::formatNumber($reportCount) ?></div>
            <div class="stat-label">Signalements</div>
            <?php if ($pendingReports > 0): ?>
                <div class="stat-change down"><i class="fas fa-exclamation-circle me-1"></i><?= $pendingReports ?> en attente</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="dashboard-card mb-4" data-aos="fade-up">
            <div class="card-header"><h5>Actions rapides</h5></div>
            <div class="card-body">
                <div class="quick-action-grid">
                    <a href="/admin/users" class="quick-action-card"><i class="fas fa-users" style="color:#F15BB5"></i><span>Utilisateurs</span></a>
                    <a href="/admin/reports" class="quick-action-card"><i class="fas fa-flag" style="color:#F44336"></i><span>Signalements<?php if ($pendingReports > 0): ?><span class="nav-badge" style="position:static;display:inline-block;margin-left:8px"><?= $pendingReports ?></span><?php endif; ?></span></a>
                    <a href="/admin/categories" class="quick-action-card"><i class="fas fa-tags" style="color:#00BCD4"></i><span>Catégories</span></a>
                    <a href="/admin/ai" class="quick-action-card"><i class="fas fa-robot" style="color:#9B5DE5"></i><span>IA</span></a>
                </div>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header"><h5>Signalements - Statistiques</h5></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3"><span style="color:rgba(255,255,255,0.6)">En attente</span><strong style="color:#FF9800"><?= $reportStats['pending'] ?></strong></div>
                <div class="d-flex justify-content-between mb-3"><span style="color:rgba(255,255,255,0.6)">Examinés</span><strong style="color:#2196F3"><?= $reportStats['reviewed'] ?></strong></div>
                <div class="d-flex justify-content-between mb-3"><span style="color:rgba(255,255,255,0.6)">Ignorés</span><strong style="color:rgba(255,255,255,0.4)"><?= $reportStats['dismissed'] ?></strong></div>
                <div class="d-flex justify-content-between"><span style="color:rgba(255,255,255,0.6)">Action prise</span><strong style="color:#F44336"><?= $reportStats['action_taken'] ?></strong></div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="dashboard-card" data-aos="fade-up" data-aos-delay="50">
            <div class="card-header"><h5>Derniers utilisateurs</h5><a href="/admin/users" class="btn-senex-outline btn-senex-sm">Voir tout</a></div>
            <div class="card-body">
                <?php if (empty($recentUsers)): ?>
                    <div class="empty-state"><i class="fas fa-users"></i><h5>Aucun utilisateur</h5></div>
                <?php else: ?>
                    <table class="table-senex">
                        <thead><tr><th>Utilisateur</th><th>Rôle</th><th>Date</th></tr></thead>
                        <tbody>
                            <?php foreach ($recentUsers as $u): ?>
                                <tr>
                                    <td><div class="user-cell"><img src="https://placehold.co/32x32/1E1E2F/F15BB5?text=<?= $u['username'][0] ?>" alt=""><span><?= htmlspecialchars($u['username']) ?></span></div></td>
                                    <td><span style="color:<?= $u['role'] === 'admin' ? '#F44336' : ($u['role'] === 'streamer' ? '#9B5DE5' : 'rgba(255,255,255,0.5)') ?>"><?= $u['role'] ?? 'user' ?></span></td>
                                    <td style="color:rgba(255,255,255,0.4)"><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
