<?php $title = 'Highlights'; ?>
<div class="section-header">
    <div><h2>Highlights</h2><p>Les meilleurs moments de vos streams</p></div>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-body">
        <?php if (empty($highlights)): ?>
            <div class="empty-state"><i class="fas fa-star"></i><h5>Aucun highlight</h5><p style="color:rgba(255,255,255,0.4);font-size:.85rem">Les highlights seront générés automatiquement par l'IA après vos streams.</p></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Titre</th><th>Stream</th><th>Vues</th><th>IA</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($highlights as $h): ?>
                        <tr>
                            <td><strong style="color:#fff"><?= htmlspecialchars($h['title'] ?? 'Highlight') ?></strong></td>
                            <td><span style="color:rgba(255,255,255,0.6)"><?= htmlspecialchars($h['stream_title'] ?? '') ?></span></td>
                            <td><?= \Core\Helpers::formatNumber($h['view_count']) ?></td>
                            <td><?= $h['is_ai_generated'] ? '<span style="color:#9B5DE5"><i class="fas fa-robot"></i> IA</span>' : '<span style="color:rgba(255,255,255,0.3)">Manuel</span>' ?></td>
                            <td><?= date('d/m/Y', strtotime($h['created_at'])) ?></td>
                            <td><button class="btn-senex-outline btn-senex-sm" onclick="alert('Lecture...')"><i class="fas fa-play"></i></button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
