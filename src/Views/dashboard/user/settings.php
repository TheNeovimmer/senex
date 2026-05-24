<?php $title = 'Paramètres'; ?>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header"><h5>Changer le mot de passe</h5></div>
            <div class="card-body">
                <form method="POST" action="/dashboard/settings/update" class="form-senex">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <div class="mb-3"><label class="form-label">Mot de passe actuel</label><input type="password" name="current_password" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Nouveau mot de passe</label><input type="password" name="new_password" class="form-control" required minlength="6"></div>
                    <div class="mb-3"><label class="form-label">Confirmer le nouveau mot de passe</label><input type="password" name="confirm_password" class="form-control" required></div>
                    <button type="submit" class="btn-senex">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="dashboard-card" data-aos="fade-up" data-aos-delay="50">
            <div class="card-header"><h5>Notifications</h5></div>
            <div class="card-body form-senex">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="notifChallenges" checked style="cursor:pointer;background-color:#F15BB5;border-color:#F15BB5">
                    <label class="form-check-label" for="notifChallenges" style="color:rgba(255,255,255,0.7)">Nouveaux défis disponibles</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="notifStreams" checked style="cursor:pointer;background-color:#F15BB5;border-color:#F15BB5">
                    <label class="form-check-label" for="notifStreams" style="color:rgba(255,255,255,0.7)">Streams en direct</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="notifBadges" checked style="cursor:pointer;background-color:#F15BB5;border-color:#F15BB5">
                    <label class="form-check-label" for="notifBadges" style="color:rgba(255,255,255,0.7)">Badges et récompenses</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="notifNewsletter" style="cursor:pointer;background-color:#F15BB5;border-color:#F15BB5">
                    <label class="form-check-label" for="notifNewsletter" style="color:rgba(255,255,255,0.7)">Newsletter SENEX</label>
                </div>
            </div>
        </div>
        <div class="dashboard-card mt-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header"><h5>Compte</h5></div>
            <div class="card-body">
                <p style="color:rgba(255,255,255,0.5);font-size:.85rem">Membre depuis le <?= date('d/m/Y', strtotime($user['created_at'] ?? 'now')) ?></p>
                <p style="color:rgba(255,255,255,0.5);font-size:.85rem">Rôle: <strong style="color:#F15BB5"><?= $user['role'] ?? 'user' ?></strong></p>
            </div>
        </div>
    </div>
</div>
