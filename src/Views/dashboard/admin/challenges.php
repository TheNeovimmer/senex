<?php $title = 'Gestion des défis'; ?>
<div class="section-header">
    <div><h2>Défis</h2><p><?= $challengesData['total'] ?> défis sur la plateforme</p></div>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-body">
        <?php if (empty($challengesData['items'])): ?>
            <div class="empty-state"><i class="fas fa-tasks"></i><h5>Aucun défi</h5></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Titre</th><th>Créateur</th><th>Difficulté</th><th>XP</th><th>Statut</th><th>Date</th></tr></thead>
                <tbody>
                    <?php foreach ($challengesData['items'] as $c): ?>
                        <tr>
                            <td><strong style="color:#fff"><?= htmlspecialchars($c['title']) ?></strong></td>
                            <td><span style="color:rgba(255,255,255,0.6)">Streamer #<?= $c['user_id'] ?></span></td>
                            <td><?= \Core\Helpers::difficultyBadge($c['difficulty']) ?></td>
                            <td><strong style="color:#FFD700"><?= $c['xp_reward'] ?> XP</strong></td>
                            <td><?= \Core\Helpers::statusBadge($c['status']) ?></td>
                            <td style="color:rgba(255,255,255,0.4)"><?= date('d/m/Y', strtotime($c['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($challengesData['lastPage'] > 1): ?>
                <div class="pagination-senex">
                    <?php for ($i = 1; $i <= $challengesData['lastPage']; $i++): ?>
                        <a href="/admin/challenges?page=<?= $i ?>" class="<?= $i === $challengesData['page'] ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
