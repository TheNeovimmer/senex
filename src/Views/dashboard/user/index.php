<?php $title = 'Tableau de bord'; ?>
<div class="dashboard-content-inner">
    <div class="section-header">
        <div>
            <h2>👋 Bon retour, <?= htmlspecialchars($user['username']) ?> !</h2>
            <p>Voici ce qui se passe sur SENEX aujourd'hui</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card" data-aos="fade-up">
                <div class="stat-icon stat-icon-pink"><i class="fas fa-trophy"></i></div>
                <div class="stat-value"><?= $profile['level'] ?? 1 ?></div>
                <div class="stat-label">Niveau</div>
                <div class="stat-change up"><i class="fas fa-arrow-up me-1"></i><?= $profile['experience_points'] ?? 0 ?> XP</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="50">
                <div class="stat-icon stat-icon-purple"><i class="fas fa-tasks"></i></div>
                <div class="stat-value"><?= count($challenges) ?></div>
                <div class="stat-label">Défis actifs</div>
                <div class="stat-change up"><i class="fas fa-arrow-up me-1"></i><?= count($recentAttempts) ?> participations</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon stat-icon-blue"><i class="fas fa-video"></i></div>
                <div class="stat-value"><?= count($liveStreams) ?></div>
                <div class="stat-label">En direct</div>
                <div class="stat-change up"><i class="fas fa-circle text-danger me-1"></i>Live maintenant</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="150">
                <div class="stat-icon stat-icon-green"><i class="fas fa-medal"></i></div>
                <div class="stat-value"><?= count($badges) ?></div>
                <div class="stat-label">Badges</div>
                <div class="stat-change up"><i class="fas fa-arrow-up me-1"></i>Collection</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="dashboard-card" data-aos="fade-up">
                <div class="card-header"><h5>Défis actifs</h5><a href="/dashboard/challenges" class="btn-senex btn-senex-sm">Voir tout</a></div>
                <div class="card-body">
                    <?php if (empty($challenges)): ?>
                        <div class="empty-state"><i class="fas fa-tasks"></i><h5>Aucun défi actif pour le moment</h5></div>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach (array_slice($challenges, 0, 4) as $challenge): ?>
                                <div class="col-md-6">
                                    <div class="challenge-card">
                                        <div class="challenge-meta">
                                            <span class="badge" style="background:<?= $challenge['difficulty'] === 'easy' ? '#4CAF50' : ($challenge['difficulty'] === 'medium' ? '#FF9800' : ($challenge['difficulty'] === 'hard' ? '#F44336' : '#9C27B0')) ?>">
                                                <?= $challenge['difficulty'] ?>
                                            </span>
                                            <span class="badge" style="background:rgba(241,91,181,0.2);color:#F15BB5"><?= $challenge['type'] ?></span>
                                        </div>
                                        <h5><?= htmlspecialchars($challenge['title']) ?></h5>
                                        <p><?= \Core\Helpers::truncate($challenge['description'] ?? '', 80) ?></p>
                                        <div class="challenge-footer">
                                            <span class="xp"><i class="fas fa-star me-1"></i><?= $challenge['xp_reward'] ?> XP</span>
                                            <button class="btn-senex btn-senex-sm" onclick="alert('Inscription au défi...')">Relever</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header"><h5>En direct</h5></div>
                <div class="card-body">
                    <?php if (empty($liveStreams)): ?>
                        <div class="empty-state"><i class="fas fa-video"></i><h5>Aucun live en cours</h5></div>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($liveStreams as $stream): ?>
                                <div class="stream-card">
                                    <div class="stream-thumb">
                                        <img src="<?= $stream['thumbnail_url'] ?? 'https://placehold.co/400x225/1E1E2F/F15BB5?text=Live' ?>" alt="">
                                        <span class="live-badge"><i class="fas fa-circle"></i> LIVE</span>
                                        <span class="viewer-count"><i class="fas fa-eye"></i> <?= \Core\Helpers::formatNumber($stream['viewer_count']) ?></span>
                                    </div>
                                    <div class="stream-body">
                                        <h5><?= htmlspecialchars($stream['title']) ?></h5>
                                        <div class="streamer-info">
                                            <img src="<?= $stream['avatar_url'] ?? 'https://placehold.co/24x24/1E1E2F/F15BB5?text=' . ($stream['username'][0] ?? 'S') ?>" alt="">
                                            <span><?= htmlspecialchars($stream['username']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
