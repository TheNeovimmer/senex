<?php $title = 'Badges'; ?>
<div class="section-header">
    <div><h2>Badges</h2><p>Créez et gérez les badges de la plateforme</p></div>
    <button class="btn-senex" data-bs-toggle="modal" data-bs-target="#createBadgeModal"><i class="fas fa-plus"></i> Nouveau badge</button>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-body">
        <?php if (empty($badges)): ?>
            <div class="empty-state"><i class="fas fa-certificate"></i><h5>Aucun badge</h5></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Badge</th><th>Type</th><th>Valeur</th><th>XP</th><th>Couleur</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($badges as $badge): ?>
                        <tr>
                            <td><strong style="color:#fff"><i class="fas fa-certificate me-2" style="color:<?= $badge['color'] ?? '#F15BB5' ?>"></i><?= htmlspecialchars($badge['name']) ?></strong></td>
                            <td><span style="color:rgba(255,255,255,0.6);text-transform:capitalize"><?= str_replace('_', ' ', $badge['criteria_type']) ?></span></td>
                            <td style="color:#fff"><?= $badge['criteria_value'] ?></td>
                            <td><strong style="color:#FFD700"><?= $badge['xp_reward'] ?> XP</strong></td>
                            <td><span style="display:inline-block;width:20px;height:20px;border-radius:4px;background:<?= $badge['color'] ?? '#F15BB5' ?>;vertical-align:middle"></span></td>
                            <td><?= $badge['is_active'] ? '<span style="color:#4CAF50">Actif</span>' : '<span style="color:#F44336">Inactif</span>' ?></td>
                            <td>
                                <form method="POST" action="/admin/badges/delete/<?= $badge['id'] ?>" class="d-inline delete-form">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                    <button type="submit" class="btn-senex-outline btn-senex-sm" style="border-color:#F44336;color:#F44336"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade modal-senex" id="createBadgeModal">
    <div class="modal-dialog">
        <form method="POST" action="/admin/badges/create" class="modal-content form-senex">
            <div class="modal-header"><h5 class="modal-title">Nouveau badge</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="mb-3"><label class="form-label">Nom</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                <div class="mb-3"><label class="form-label">Type de critère</label><select name="criteria_type" class="form-select">
                    <option value="xp_level">Niveau XP</option><option value="challenge_count">Défis complétés</option>
                    <option value="stream_count">Streams effectués</option><option value="follower_count">Nombre d'abonnés</option>
                    <option value="streak">Jours consécutifs</option><option value="special">Spécial</option>
                </select></div>
                <div class="mb-3"><label class="form-label">Valeur du critère</label><input type="number" name="criteria_value" class="form-control" value="1" min="0"></div>
                <div class="mb-3"><label class="form-label">XP Récompense</label><input type="number" name="xp_reward" class="form-control" value="100" min="0"></div>
                <div class="mb-3"><label class="form-label">Couleur</label><input type="color" name="color" class="form-control form-control-color" value="#F15BB5" style="width:60px;height:40px;padding:4px"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn-senex-outline btn-senex-sm" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-senex btn-senex-sm">Créer</button></div>
        </form>
    </div>
</div>
