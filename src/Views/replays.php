<section class="section-padding px-3">
  <div class="container">
    <div class="hero-bordered-sm text-center py-5 mb-5" data-aos="fade-up">
      <h1 class="fw-bold text-white mb-3 heading-xl ls-md">REPLAYS</h1>
      <p class="fw-bold text-white mb-2 heading-sm">Watch. Learn. Improve.</p>
      <p class="replay-hero-desc">Relive the best moments and get inspired.</p>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap mb-5" data-aos="fade-up">
      <div class="position-relative mw-580 w-100">
        <div class="search-bar w-100"></div>
        <i class="fas fa-search search-bar-icon"></i>
        <span class="search-bar-text">Search replays ; tag or user</span>
      </div>
      <div class="position-relative mw-200 w-100">
        <div class="search-bar w-100"></div>
        <span class="position-absolute top-50 translate-middle-y text-white replay-search-text">All categories</span>
        <i class="fas fa-chevron-down position-absolute top-50 translate-middle-y replay-chevron-down"></i>
      </div>
      <div class="search-bar d-flex align-items-center justify-content-center w-73">
        <i class="fas fa-sliders-h text-white replay-filter-icon"></i>
      </div>
    </div>

    <div class="mx-auto mw-1174" data-aos="fade-up">
      <?php if (!empty($replays)): ?>
        <?php foreach ($replays as $replay): ?>
        <div class="d-flex flex-column flex-lg-row align-items-start gap-4 mb-5 pb-4 section-divider">
          <a href="/replay/<?= $replay['id'] ?>" class="replay-thumb-wrapper" style="text-decoration:none">
            <img src="<?= $replay['thumbnail_url'] ?? 'https://placehold.co/406x266/1E1E2F/F15BB5?text=Replay' ?>" alt="<?= htmlspecialchars($replay['title']) ?>" class="w-100 rounded-4">
            <div class="replay-play-overlay">
              <i class="fas fa-play text-white fs-3"></i>
            </div>
            <span class="replay-duration"><?= htmlspecialchars($replay['duration'] ?? '--:--') ?></span>
          </a>
          <div class="flex-grow-1">
            <h4 class="replay-title"><?= htmlspecialchars($replay['title']) ?></h4>
            <p class="replay-desc"><?= htmlspecialchars($replay['description'] ?? $replay['title']) ?></p>
            <div class="replay-stats">
              <div class="replay-stat-item">
                <i class="fas fa-eye replay-stat-icon"></i>
                <span class="replay-stat-label"><?= \Core\Helpers::formatNumber($replay['view_count'] ?? 0) ?></span>
              </div>
              <div class="replay-stat-item">
                <i class="fas fa-heart text-accent replay-heart-icon"></i>
                <span class="replay-stat-label"><?= \Core\Helpers::formatNumber($replay['like_count'] ?? 0) ?></span>
              </div>
              <div class="replay-stat-item">
                <i class="fas fa-comment replay-stat-icon"></i>
                <span class="replay-stat-label"><?= \Core\Helpers::formatNumber($replay['comment_count'] ?? 0) ?></span>
              </div>
              <div class="replay-stat-item">
                <i class="fas fa-play replay-stat-icon replay-play-icon-sm"></i>
                <span class="replay-stat-label"><?= \Core\Helpers::formatNumber($replay['play_count'] ?? 0) ?></span>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="replay-timestamp"><?= $replay['username'] ?? '' ?> · <?= !empty($replay['created_at']) ? (new DateTime($replay['created_at']))->diff(new DateTime())->days . ' days ago' : '' ?></span>
              <i class="fas fa-ellipsis-v ellipsis-btn"></i>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="text-center py-5">
          <p class="text-white-50 fs-5">No replays available yet. Check back soon!</p>
          <a href="/" class="btn btn-outline-senex mt-3">Go Home</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
