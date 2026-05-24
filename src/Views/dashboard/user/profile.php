<?php $title = 'Profil'; ?>
<div class="row g-4">
    <div class="col-12">
        <div class="profile-header-card" data-aos="fade-up">
            <img src="<?= $user['avatar_url'] ?? 'https://placehold.co/96x96/1E1E2F/F15BB5?text=' . ($user['username'][0] ?? 'U') ?>" alt="Avatar" class="profile-avatar">
            <div class="flex-grow-1">
                <h3 class="mb-1" style="color:#fff;font-weight:800"><?= htmlspecialchars($user['display_name'] ?? $user['username']) ?></h3>
                <p style="color:rgba(255,255,255,0.5);margin:0">@<?= htmlspecialchars($user['username']) ?></p>
                <div class="d-flex gap-3 mt-2">
                    <span style="color:rgba(255,255,255,0.6);font-size:.85rem"><strong style="color:#F15BB5"><?= $profile['level'] ?? 1 ?></strong> Niveau</span>
                    <span style="color:rgba(255,255,255,0.6);font-size:.85rem"><strong style="color:#F15BB5"><?= $profile['experience_points'] ?? 0 ?></strong> XP</span>
                    <span style="color:rgba(255,255,255,0.6);font-size:.85rem"><strong style="color:#F15BB5"><?= count($followers) ?></strong> Abonnés</span>
                </div>
            </div>
            <button class="btn-senex btn-senex-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="fas fa-edit"></i> Modifier
            </button>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header"><h5>À propos</h5></div>
            <div class="card-body">
                <?php if ($profile && !empty($profile['bio'])): ?>
                    <p style="color:rgba(255,255,255,0.7)"><?= nl2br(htmlspecialchars($profile['bio'])) ?></p>
                <?php else: ?>
                    <p style="color:rgba(255,255,255,0.3)">Aucune bio pour le moment.</p>
                <?php endif; ?>
                <?php if ($profile && !empty($profile['skills'])): $skills = json_decode($profile['skills'], true); if (is_array($skills) && !empty($skills)): ?>
                    <div class="mt-3"><strong style="color:rgba(255,255,255,0.7)">Compétences</strong><div class="badge-grid mt-2"><?php foreach ($skills as $skill): if (empty($skill)) continue; ?><span class="badge-item"><i class="fas fa-check-circle"></i><?= htmlspecialchars(trim($skill)) ?></span><?php endforeach; ?></div></div>
                <?php endif; endif; ?>
            </div>
        </div>

        <div class="dashboard-card mt-4" data-aos="fade-up">
            <div class="card-header"><h5>Badges</h5></div>
            <div class="card-body">
                <?php if (empty($badges)): ?>
                    <div class="empty-state"><i class="fas fa-certificate"></i><h5>Pas encore de badges</h5><p style="color:rgba(255,255,255,0.4);font-size:.85rem">Participez à des défis pour gagner des badges !</p></div>
                <?php else: ?>
                    <div class="badge-grid"><?php foreach ($badges as $badge): ?><span class="badge-item" style="border-color:<?= $badge['color'] ?? '#F15BB5' ?>;color:<?= $badge['color'] ?? '#F15BB5' ?>"><i class="fas fa-certificate"></i><?= htmlspecialchars($badge['name']) ?></span><?php endforeach; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header"><h5>Statistiques</h5></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3"><span style="color:rgba(255,255,255,0.5)">Défis complétés</span><strong style="color:#fff"><?= $profile['total_challenges'] ?? 0 ?></strong></div>
                <div class="d-flex justify-content-between mb-3"><span style="color:rgba(255,255,255,0.5)">Streams regardés</span><strong style="color:#fff"><?= $profile['total_streams'] ?? 0 ?></strong></div>
                <div class="d-flex justify-content-between mb-3"><span style="color:rgba(255,255,255,0.5)">Abonnements</span><strong style="color:#fff"><?= $profile['total_followers'] ?? 0 ?></strong></div>
                <div class="d-flex justify-content-between"><span style="color:rgba(255,255,255,0.5)">Score popularité</span><strong style="color:#F15BB5"><?= number_format($profile['popularity_score'] ?? 0, 1) ?></strong></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-senex" id="editProfileModal">
    <div class="modal-dialog">
        <form method="POST" action="/dashboard/profile/update" class="modal-content form-senex">
            <div class="modal-header"><h5 class="modal-title">Modifier le profil</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="mb-3"><label class="form-label">Nom d'affichage</label><input type="text" name="display_name" class="form-control" value="<?= htmlspecialchars($user['display_name'] ?? $user['username']) ?>"></div>
                <div class="mb-3"><label class="form-label">Avatar URL</label><input type="text" name="avatar_url" class="form-control" value="<?= htmlspecialchars($user['avatar_url'] ?? '') ?>" placeholder="https://placehold.co/96x96/..."></div>
                <div class="mb-3"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="4" placeholder="Parle-nous de toi..."><?= htmlspecialchars($profile['bio'] ?? '') ?></textarea></div>
                <div class="mb-3"><label class="form-label">Compétences (séparées par des virgules)</label><input type="text" name="skills" class="form-control" value="<?= $profile && !empty($profile['skills']) ? implode(', ', json_decode($profile['skills'], true) ?: []) : '' ?>" placeholder="Gaming, Stratégie, Créativité"></div>
                <div class="mb-3"><label class="form-label">Twitter</label><input type="text" name="twitter" class="form-control" placeholder="@username"></div>
                <div class="mb-3"><label class="form-label">Instagram</label><input type="text" name="instagram" class="form-control" placeholder="@username"></div>
                <div class="mb-3"><label class="form-label">GitHub</label><input type="text" name="github" class="form-control" placeholder="username"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn-senex-outline btn-senex-sm" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-senex btn-senex-sm">Enregistrer</button></div>
        </form>
    </div>
</div>
