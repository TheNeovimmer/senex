<section class="section-padding px-3">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h1 class="fw-bold text-white mb-3 heading-md">RECHERCHE</h1>
      <form method="GET" action="/search" class="mx-auto" style="max-width:500px">
        <div class="d-flex gap-2">
          <input type="text" name="q" class="form-control" placeholder="Rechercher des utilisateurs, streams, défis..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#fff">
          <button type="submit" class="btn btn-senex"><i class="fas fa-search"></i></button>
        </div>
      </form>
    </div>

    <?php if (strlen($_GET['q'] ?? '') >= 2): ?>
    <div class="row g-4" data-aos="fade-up">
      <?php if (!empty($users)): ?>
      <div class="col-12">
        <h4 class="text-accent mb-3"><i class="fas fa-users me-2"></i>Utilisateurs</h4>
        <div class="row g-3">
          <?php foreach ($users as $u): ?>
          <div class="col-md-4 col-lg-3">
            <a href="/profile/<?= $u['id'] ?>" style="text-decoration:none">
              <div class="card-activity-alt p-3 d-flex align-items-center gap-3">
                <img src="<?= $u['avatar_url'] ?? 'https://placehold.co/48x48/1E1E2F/F15BB5?text=' . ($u['username'][0] ?? 'U') ?>" alt="" style="width:48px;height:48px;border-radius:50%;object-fit:cover">
                <div>
                  <h6 class="text-white mb-0"><?= htmlspecialchars($u['display_name'] ?? $u['username']) ?></h6>
                  <small class="text-white-50">@<?= htmlspecialchars($u['username']) ?></small>
                </div>
              </div>
            </a>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php if (!empty($streams)): ?>
      <div class="col-12 mt-4">
        <h4 class="text-accent mb-3"><i class="fas fa-video me-2"></i>Streams</h4>
        <div class="row g-3">
          <?php foreach ($streams as $s): ?>
          <div class="col-md-6">
            <a href="/stream/<?= $s['id'] ?>" style="text-decoration:none">
              <div class="card-activity p-3 d-flex align-items-center gap-3">
                <i class="fas fa-broadcast-tower fa-2x" style="color:<?= $s['status'] === 'live' ? '#F44336' : '#666' ?>"></i>
                <div>
                  <h6 class="text-white mb-0"><?= htmlspecialchars($s['title']) ?></h6>
                  <small class="text-white-50"><?= htmlspecialchars($s['username']) ?> · <?= $s['status'] ?></small>
                </div>
              </div>
            </a>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php if (!empty($challenges)): ?>
      <div class="col-12 mt-4">
        <h4 class="text-accent mb-3"><i class="fas fa-trophy me-2"></i>Défis</h4>
        <div class="row g-3">
          <?php foreach ($challenges as $c): ?>
          <div class="col-md-6">
            <a href="/leaderboard/<?= $c['id'] ?>" style="text-decoration:none">
              <div class="card-activity-alt p-3 d-flex align-items-center gap-3">
                <i class="fas fa-tasks fa-2x" style="color:#F15BB5"></i>
                <div>
                  <h6 class="text-white mb-0"><?= htmlspecialchars($c['title']) ?></h6>
                  <small class="text-white-50"><?= htmlspecialchars($c['username']) ?> · <?= $c['xp_reward'] ?> XP</small>
                </div>
              </div>
            </a>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php if (empty($users) && empty($streams) && empty($challenges)): ?>
      <div class="col-12 text-center py-5">
        <i class="fas fa-search fa-3x text-white-50 mb-3"></i>
        <h4 class="text-white">Aucun résultat</h4>
        <p class="text-white-50">Essayez d'autres termes de recherche.</p>
      </div>
      <?php endif; ?>
    </div>
    <?php elseif (isset($_GET['q']) && strlen($_GET['q']) > 0 && strlen($_GET['q']) < 2): ?>
    <div class="text-center py-5">
      <p class="text-white-50">Minimum 2 caractères pour lancer une recherche.</p>
    </div>
    <?php endif; ?>
  </div>
</section>
