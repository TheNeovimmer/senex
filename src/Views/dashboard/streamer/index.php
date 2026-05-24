<?php $title = 'Studio Streamer'; ?>
<div class="section-header">
    <div><h2>Studio Streamer</h2><p>Gérez vos streams, défis et contenu</p></div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card" data-aos="fade-up">
            <div class="stat-icon stat-icon-pink"><i class="fas fa-video"></i></div>
            <div class="stat-value"><?= $totalStreams ?></div>
            <div class="stat-label">Total streams</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="50">
            <div class="stat-icon stat-icon-purple"><i class="fas fa-eye"></i></div>
            <div class="stat-value"><?= \Core\Helpers::formatNumber($totalViews) ?></div>
            <div class="stat-label">Vues totales</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-icon stat-icon-blue"><i class="fas fa-trophy"></i></div>
            <div class="stat-value"><?= count($challenges) ?></div>
            <div class="stat-label">Défis créés</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="150">
            <div class="stat-icon<?= $liveStream ? ' stat-icon-red' : ' stat-icon-green' ?>"><?php if ($liveStream): ?><i class="fas fa-circle" style="animation:pulse 1.5s infinite"></i><?php else: ?><i class="fas fa-circle"></i><?php endif; ?></div>
            <div class="stat-value"><?= $liveStream ? 'En direct' : 'Hors ligne' ?></div>
            <div class="stat-label">Statut</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="dashboard-card mb-4" data-aos="fade-up">
            <div class="card-header"><h5>Actions rapides</h5></div>
            <div class="card-body">
                <div class="quick-action-grid">
                    <a href="#" class="quick-action-card" data-bs-toggle="modal" data-bs-target="#createStreamModal">
                        <i class="fas fa-broadcast-tower" style="color:#F15BB5"></i>
                        <span>Nouveau stream</span>
                        <small>Planifier ou lancer</small>
                    </a>
                    <a href="/streamer/challenges" class="quick-action-card">
                        <i class="fas fa-trophy" style="color:#9B5DE5"></i>
                        <span>Créer un défi</span>
                        <small>Engage ta communauté</small>
                    </a>
                    <a href="/streamer/streams" class="quick-action-card">
                        <i class="fas fa-history" style="color:#00BCD4"></i>
                        <span>Mes streams</span>
                        <small>Voir l'historique</small>
                    </a>
                    <a href="/streamer/replays" class="quick-action-card">
                        <i class="fas fa-play-circle" style="color:#4CAF50"></i>
                        <span>Replays</span>
                        <small>Contenu archivé</small>
                    </a>
                </div>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header"><h5>Streams récents</h5></div>
            <div class="card-body">
                <?php if (empty($streams)): ?>
                    <div class="empty-state"><i class="fas fa-video"></i><h5>Pas encore de streams</h5></div>
                <?php else: ?>
                    <table class="table-senex">
                        <thead><tr><th>Titre</th><th>Statut</th><th>Vues</th><th>Durée</th><th>Date</th></tr></thead>
                        <tbody>
                            <?php foreach (array_slice($streams, 0, 5) as $s): ?>
                                <tr>
                                    <td><a href="<?= $s['status'] === 'live' ? '/streamer/live/' . $s['id'] : '#' ?>" style="color:#fff;text-decoration:none"><?= htmlspecialchars($s['title']) ?></a></td>
                                    <td><?= \Core\Helpers::statusBadge($s['status']) ?></td>
                                    <td><?= \Core\Helpers::formatNumber($s['viewer_count']) ?></td>
                                    <td><?= \Core\Helpers::formatDuration($s['duration_seconds']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($s['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-card mb-4" data-aos="fade-up" data-aos-delay="50">
            <div class="card-header"><h5>Défis récents</h5></div>
            <div class="card-body">
                <?php if (empty($challenges)): ?>
                    <div class="empty-state"><i class="fas fa-trophy"></i><h5>Aucun défi créé</h5></div>
                <?php else: foreach (array_slice($challenges, 0, 3) as $c): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div><strong style="color:#fff;font-size:.85rem"><?= htmlspecialchars($c['title']) ?></strong><br><small style="color:rgba(255,255,255,0.4)"><?= $c['difficulty'] ?> · <?= $c['xp_reward'] ?> XP</small></div>
                        <span><?= \Core\Helpers::statusBadge($c['status']) ?></span>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>

        <?php if ($liveStream): ?>
            <div class="dashboard-card" data-aos="fade-up" data-aos-delay="100" style="border-color:rgba(244,67,54,0.3)">
                <div class="card-header"><h5 style="color:#F44336"><i class="fas fa-circle me-2" style="animation:pulse 1.5s infinite"></i>Live en cours</h5></div>
                <div class="card-body text-center">
                    <p style="color:rgba(255,255,255,0.7);font-size:.9rem"><?= htmlspecialchars($liveStream['title']) ?></p>
                    <p style="color:rgba(255,255,255,0.4);font-size:.78rem"><i class="fas fa-eye me-1"></i><?= $liveStream['viewer_count'] ?> spectateurs</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="/streamer/live/<?= $liveStream['id'] ?>" class="btn-senex btn-senex-sm"><i class="fas fa-external-link-alt"></i>Studio live</a>
                        <a href="/streamer/end-live/<?= $liveStream['id'] ?>" class="btn-senex btn-senex-danger btn-senex-sm" onclick="return confirm('Terminer le stream?')"><i class="fas fa-stop"></i>Arrêter</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade modal-senex" id="createStreamModal">
    <div class="modal-dialog">
        <form method="POST" action="/streamer/create" class="modal-content form-senex">
            <div class="modal-header"><h5 class="modal-title">Nouveau stream</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="mb-3"><label class="form-label">Titre du stream</label><input type="text" name="title" class="form-control" required placeholder="Mon stream SENEX"></div>
                <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3" placeholder="Dis aux viewers à quoi s'attendre..."></textarea></div>
                <div class="mb-3"><label class="form-label">Catégorie</label><select name="category_id" class="form-select"><option value="">Sélectionner...</option><?php foreach ($categories as $cat): ?><option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option><?php endforeach; ?></select></div>
                <div class="mb-3"><label class="form-label">URL miniature</label><input type="text" name="thumbnail_url" class="form-control" placeholder="https://placehold.co/400x225/..."></div>
                <div class="mb-3"><label class="form-label">Planifier (optionnel)</label><input type="datetime-local" name="scheduled_at" class="form-control"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn-senex-outline btn-senex-sm" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-senex btn-senex-sm">Créer le stream</button></div>
        </form>
    </div>
</div>
