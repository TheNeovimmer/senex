<?php $title = 'Catégories'; ?>
<div class="section-header">
    <div><h2>Catégories</h2><p>Gérez les catégories de contenu</p></div>
    <button class="btn-senex" data-bs-toggle="modal" data-bs-target="#createCategoryModal"><i class="fas fa-plus"></i> Nouvelle catégorie</button>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-body">
        <?php if (empty($categories)): ?>
            <div class="empty-state"><i class="fas fa-tags"></i><h5>Aucune catégorie</h5></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Nom</th><th>Slug</th><th>Type</th><th>Couleur</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><strong style="color:#fff"><i class="fas fa-<?= $cat['icon'] ?? 'tag' ?> me-2" style="color:<?= $cat['color'] ?? '#F15BB5' ?>"></i><?= htmlspecialchars($cat['name']) ?></strong></td>
                            <td style="color:rgba(255,255,255,0.5)"><?= htmlspecialchars($cat['slug']) ?></td>
                            <td><span style="color:rgba(255,255,255,0.6);text-transform:capitalize"><?= $cat['type'] ?></span></td>
                            <td><span style="display:inline-block;width:20px;height:20px;border-radius:4px;background:<?= $cat['color'] ?? '#F15BB5' ?>;vertical-align:middle"></span></td>
                            <td><?= $cat['is_active'] ? '<span style="color:#4CAF50">Actif</span>' : '<span style="color:#F44336">Inactif</span>' ?></td>
                            <td>
                                <form method="POST" action="/admin/categories/delete/<?= $cat['id'] ?>" class="d-inline delete-form">
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

<div class="modal fade modal-senex" id="createCategoryModal">
    <div class="modal-dialog">
        <form method="POST" action="/admin/categories/create" class="modal-content form-senex">
            <div class="modal-header"><h5 class="modal-title">Nouvelle catégorie</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="mb-3"><label class="form-label">Nom</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Type</label><select name="type" class="form-select"><option value="both">Stream & Défi</option><option value="stream">Stream uniquement</option><option value="challenge">Défi uniquement</option></select></div>
                <div class="mb-3"><label class="form-label">Icône (FontAwesome)</label><input type="text" name="icon" class="form-control" placeholder="gamepad, puzzle-piece, ..."></div>
                <div class="mb-3"><label class="form-label">Couleur</label><input type="color" name="color" class="form-control form-control-color" value="#F15BB5" style="width:60px;height:40px;padding:4px"></div>
                <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn-senex-outline btn-senex-sm" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-senex btn-senex-sm">Créer</button></div>
        </form>
    </div>
</div>
