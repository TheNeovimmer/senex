<?php $title = 'Défis'; ?>
<div class="section-header">
    <div><h2>Défis</h2><p>Relève les défis et gagne de l'XP et des badges</p></div>
</div>

<div class="dashboard-card mb-4" data-aos="fade-up">
    <div class="card-header"><h5>Défis disponibles</h5></div>
    <div class="card-body">
        <?php if (empty($activeChallenges)): ?>
            <div class="empty-state"><i class="fas fa-tasks"></i><h5>Aucun défi disponible</h5><p style="color:rgba(255,255,255,0.4);font-size:.85rem">Reviens plus tard pour de nouveaux défis !</p></div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($activeChallenges as $challenge): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="challenge-card">
                            <div class="challenge-meta">
                                <span class="badge" style="background:<?= $challenge['difficulty'] === 'easy' ? '#4CAF50' : ($challenge['difficulty'] === 'medium' ? '#FF9800' : ($challenge['difficulty'] === 'hard' ? '#F44336' : '#9C27B0')) ?>"><?= $challenge['difficulty'] ?></span>
                                <span class="badge" style="background:rgba(241,91,181,0.2);color:#F15BB5"><?= $challenge['type'] ?></span>
                            </div>
                            <h5><?= htmlspecialchars($challenge['title']) ?></h5>
                            <p><?= \Core\Helpers::truncate($challenge['description'] ?? '', 100) ?></p>
                            <div class="challenge-footer">
                                <span class="xp"><i class="fas fa-star me-1"></i><?= $challenge['xp_reward'] ?> XP</span>
                                <span style="color:rgba(255,255,255,0.4);font-size:.8rem"><i class="far fa-clock me-1"></i><?= \Core\Helpers::formatDuration($challenge['duration_seconds']) ?></span>
                                <button class="btn-senex btn-senex-sm" onclick="alert('Lancement du défi: <?= htmlspecialchars($challenge['title'], ENT_QUOTES) ?>')">Relever</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-header"><h5>Mon historique</h5></div>
    <div class="card-body">
        <?php if (empty($attempts)): ?>
            <div class="empty-state"><i class="fas fa-history"></i><h5>Aucune participation</h5></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Défi</th><th>Score</th><th>Temps</th><th>Date</th><th>Statut</th></tr></thead>
                <tbody>
                    <?php foreach (array_slice($attempts, 0, 20) as $attempt): ?>
                        <tr>
                            <td>Défi #<?= $attempt['challenge_id'] ?></td>
                            <td><strong style="color:#FFD700"><?= $attempt['score'] ?? '-' ?></strong></td>
                            <td><?= $attempt['time_taken_seconds'] ? \Core\Helpers::formatDuration($attempt['time_taken_seconds']) : '-' ?></td>
                            <td><?= date('d/m/Y', strtotime($attempt['started_at'])) ?></td>
                            <td><?= $attempt['completed'] ? '<span style="color:#4CAF50">✅ Complété</span>' : '<span style="color:#FF9800">⏳ En cours</span>' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
