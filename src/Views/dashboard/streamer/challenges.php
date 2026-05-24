<?php $title = 'Mes Défis'; ?>
<div class="section-header">
    <div><h2>Mes Défis</h2><p>Créez et gérez les défis pour votre communauté</p></div>
    <button class="btn-senex" data-bs-toggle="modal" data-bs-target="#createChallengeModal"><i class="fas fa-plus"></i> Nouveau défi</button>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-body">
        <?php if (empty($challenges)): ?>
            <div class="empty-state"><i class="fas fa-trophy"></i><h5>Aucun défi créé</h5><p style="color:rgba(255,255,255,0.4);font-size:.85rem">Créez votre premier défi pour engager votre communauté !</p></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Titre</th><th>Difficulté</th><th>Type</th><th>XP</th><th>Durée</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($challenges as $c): ?>
                        <tr>
                            <td><strong style="color:#fff"><?= htmlspecialchars($c['title']) ?></strong></td>
                            <td><?= \Core\Helpers::difficultyBadge($c['difficulty']) ?></td>
                            <td><span style="color:rgba(255,255,255,0.6);text-transform:capitalize"><?= $c['type'] ?></span></td>
                            <td><strong style="color:#FFD700"><?= $c['xp_reward'] ?> XP</strong></td>
                            <td><?= \Core\Helpers::formatDuration($c['duration_seconds']) ?></td>
                            <td><?= \Core\Helpers::statusBadge($c['status']) ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <?php if ($c['status'] === 'draft'): ?>
                                        <a href="/streamer/challenges/activate/<?= $c['id'] ?>" class="btn-senex btn-senex-sm btn-senex-success">Activer</a>
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

<div class="modal fade modal-senex" id="createChallengeModal">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="/streamer/challenges/create" class="modal-content form-senex">
            <div class="modal-header"><h5 class="modal-title">Créer un défi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Titre du défi</label><input type="text" name="title" class="form-control" required></div>
                    <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
                    <div class="col-12"><label class="form-label">Règles</label><textarea name="rules" class="form-control" rows="3"></textarea></div>
                    <div class="col-md-4"><label class="form-label">Difficulté</label><select name="difficulty" class="form-select"><option value="easy">Facile</option><option value="medium" selected>Moyen</option><option value="hard">Difficile</option><option value="extreme">Extrême</option></select></div>
                    <div class="col-md-4"><label class="form-label">Type</label><select name="type" class="form-select"><option value="solo">Solo</option><option value="team">Équipe</option><option value="viewer">Viewer</option></select></div>
                    <div class="col-md-4"><label class="form-label">Catégorie</label><select name="category_id" class="form-select"><option value="">Aucune</option><?php foreach ($categories as $cat): ?><option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option><?php endforeach; ?></select></div>
                    <div class="col-md-4"><label class="form-label">Durée (secondes)</label><input type="number" name="duration_seconds" class="form-control" value="60" min="10" max="3600"></div>
                    <div class="col-md-4"><label class="form-label">XP Récompense</label><input type="number" name="xp_reward" class="form-control" value="100" min="0"></div>
                    <div class="col-12"><label class="form-label">Objectifs (un par ligne)</label><textarea name="objectives" class="form-control" rows="4" placeholder="Atteindre 10 kills&#10;Compléter le parcours&#10;Trouver 5 objets cachés"></textarea></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn-senex-outline btn-senex-sm" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-senex btn-senex-sm">Créer le défi</button></div>
        </form>
    </div>
</div>
