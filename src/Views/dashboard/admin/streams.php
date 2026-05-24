<?php $title = 'Gestion des streams'; ?>
<div class="section-header">
    <div><h2>Streams</h2><p><?= $streamsData['total'] ?> streams sur la plateforme</p></div>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-body">
        <?php if (empty($streamsData['items'])): ?>
            <div class="empty-state"><i class="fas fa-video"></i><h5>Aucun stream</h5></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Titre</th><th>Streamer</th><th>Statut</th><th>Vues</th><th>Durée</th><th>Date</th></tr></thead>
                <tbody>
                    <?php foreach ($streamsData['items'] as $s): ?>
                        <tr>
                            <td><strong style="color:#fff"><?= htmlspecialchars($s['title']) ?></strong></td>
                            <td><span style="color:rgba(255,255,255,0.6)">Streamer #<?= $s['user_id'] ?></span></td>
                            <td><?= \Core\Helpers::statusBadge($s['status']) ?></td>
                            <td><?= \Core\Helpers::formatNumber($s['viewer_count']) ?></td>
                            <td><?= \Core\Helpers::formatDuration($s['duration_seconds']) ?></td>
                            <td style="color:rgba(255,255,255,0.4)"><?= date('d/m/Y', strtotime($s['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($streamsData['lastPage'] > 1): ?>
                <div class="pagination-senex">
                    <?php for ($i = 1; $i <= $streamsData['lastPage']; $i++): ?>
                        <a href="/admin/streams?page=<?= $i ?>" class="<?= $i === $streamsData['page'] ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
