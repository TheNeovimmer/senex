<section class="section-padding px-3">
  <div class="container">
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-8 text-center">
        <img src="<?= $profileUser['avatar_url'] ?? 'https://placehold.co/120x120/1E1E2F/F15BB5?text=' . ($profileUser['username'][0] ?? 'U') ?>" alt="" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #F15BB5;margin-bottom:16px">
        <h2 class="text-white"><?= htmlspecialchars($profileUser['display_name'] ?? $profileUser['username']) ?></h2>
        <p class="text-white-50 mb-1">@<?= htmlspecialchars($profileUser['username']) ?></p>
        <p class="text-white-50 mb-4">Membre depuis <?= date('d/m/Y', strtotime($profileUser['created_at'])) ?></p>

        <?php if ($profile && !empty($profile['bio'])): ?>
        <p class="text-white mb-4 mx-auto" style="max-width:500px"><?= nl2br(htmlspecialchars($profile['bio'])) ?></p>
        <?php endif; ?>

        <div class="d-flex justify-content-center gap-4 mb-4">
          <div><strong class="text-accent"><?= $profile['level'] ?? 1 ?></strong><br><small class="text-white-50">Niveau</small></div>
          <div><strong class="text-accent"><?= $profile['experience_points'] ?? 0 ?></strong><br><small class="text-white-50">XP</small></div>
          <div><strong class="text-accent"><?= $profile['total_challenges'] ?? 0 ?></strong><br><small class="text-white-50">Défis</small></div>
        </div>

        <?php if (!empty($badges)): ?>
        <h5 class="text-white mb-3">Badges</h5>
        <div class="d-flex justify-content-center gap-2 flex-wrap mb-4">
          <?php foreach ($badges as $badge): ?>
          <span class="badge" style="background:<?= $badge['color'] ?? '#F15BB5' ?>;padding:8px 16px;font-size:.85rem">
            <i class="fas fa-certificate me-1"></i><?= htmlspecialchars($badge['name']) ?>
          </span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <a href="/streams" class="btn btn-outline-senex mt-2">Voir les streams</a>
      </div>
    </div>
  </div>
</section>
