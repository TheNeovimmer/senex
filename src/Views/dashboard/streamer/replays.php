<?php $title = 'Replays'; ?>
<div class="section-header">
    <div><h2>Replays</h2><p>Vos streams archivés</p></div>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-body">
        <?php if (empty($replays)): ?>
            <div class="empty-state"><i class="fas fa-history"></i><h5>Aucun replay disponible</h5><p style="color:rgba(255,255,255,0.4);font-size:.85rem">Les replays apparaîtront après vos streams.</p></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Titre</th><th>Stream</th><th>Durée</th><th>Vues</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($replays as $r): ?>
                        <tr>
                            <td><strong style="color:#fff"><?= htmlspecialchars($r['title']) ?></strong></td>
                            <td><span style="color:rgba(255,255,255,0.6)"><?= htmlspecialchars($r['stream_title'] ?? '') ?></span></td>
                            <td><?= \Core\Helpers::formatDuration($r['duration_seconds']) ?></td>
                            <td><?= \Core\Helpers::formatNumber($r['view_count']) ?></td>
                            <td><?= date('d/m/Y', strtotime($r['created_at'])) ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn-senex-outline btn-senex-sm" onclick="alert('Lecture du replay...')"><i class="fas fa-play"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
