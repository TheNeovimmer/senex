<?php $title = 'Mes Streams'; ?>
<div class="section-header">
    <div><h2>Mes Streams</h2><p>Tous vos streams, passés et à venir</p></div>
    <button class="btn-senex" data-bs-toggle="modal" data-bs-target="#createStreamModal"><i class="fas fa-plus"></i> Nouveau stream</button>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-body">
        <?php if (empty($streams)): ?>
            <div class="empty-state"><i class="fas fa-video"></i><h5>Aucun stream pour le moment</h5><p style="color:rgba(255,255,255,0.4);font-size:.85rem">Créez votre premier stream !</p><button class="btn-senex mt-3" data-bs-toggle="modal" data-bs-target="#createStreamModal"><i class="fas fa-plus"></i> Créer un stream</button></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Titre</th><th>Statut</th><th>Catégorie</th><th>Vues</th><th>Pic</th><th>Durée</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($streams as $s): ?>
                        <tr>
                            <td><strong style="color:#fff"><?= htmlspecialchars($s['title']) ?></strong></td>
                            <td><?= \Core\Helpers::statusBadge($s['status']) ?></td>
                            <td><span style="color:rgba(255,255,255,0.5)"><?= $s['category_id'] ? 'Catégorie #' . $s['category_id'] : 'Non catégorisé' ?></span></td>
                            <td><?= \Core\Helpers::formatNumber($s['viewer_count']) ?></td>
                            <td><?= \Core\Helpers::formatNumber($s['peak_viewers']) ?></td>
                            <td><?= \Core\Helpers::formatDuration($s['duration_seconds']) ?></td>
                            <td><?= date('d/m/Y', strtotime($s['created_at'])) ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <?php if ($s['status'] === 'scheduled'): ?>
                                        <a href="/streamer/go-live/<?= $s['id'] ?>" class="btn-senex btn-senex-sm">Go Live</a>
                                    <?php elseif ($s['status'] === 'live'): ?>
                                        <a href="/streamer/live/<?= $s['id'] ?>" class="btn-senex btn-senex-sm"><i class="fas fa-circle text-danger me-1"></i>Studio</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade modal-senex" id="createStreamModal">
    <div class="modal-dialog">
        <form method="POST" action="/streamer/create" class="modal-content form-senex">
            <div class="modal-header"><h5 class="modal-title">Nouveau stream</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="mb-3"><label class="form-label">Titre</label><input type="text" name="title" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
                <div class="mb-3"><label class="form-label">Catégorie</label><select name="category_id" class="form-select"><option value="">Sélectionner...</option><?php foreach ($categories as $cat): ?><option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option><?php endforeach; ?></select></div>
                <div class="mb-3"><label class="form-label">Miniature</label><input type="text" name="thumbnail_url" class="form-control" placeholder="https://placehold.co/400x225/..."></div>
                <div class="mb-3"><label class="form-label">Planifier</label><input type="datetime-local" name="scheduled_at" class="form-control"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn-senex-outline btn-senex-sm" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-senex btn-senex-sm">Créer</button></div>
        </form>
    </div>
</div>
