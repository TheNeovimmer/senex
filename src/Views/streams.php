<section class="section-padding px-3">
  <div class="container">
    <div class="text-center py-5 mb-5" data-aos="fade-up">
      <h1 class="fw-bold text-white mb-3 heading-xl ls-md">STREAMS</h1>
      <p class="fw-bold text-white mb-2 heading-sm">Watch live challenges and interact</p>
    </div>

    <?php if (!empty($liveStreams)): ?>
    <h2 class="text-accent mb-4" data-aos="fade-up"><i class="fas fa-circle text-danger me-2"></i>EN DIRECT</h2>
    <div class="row g-4 mb-5" data-aos="fade-up">
      <?php foreach ($liveStreams as $stream): ?>
      <div class="col-md-6 col-lg-4">
        <a href="/stream/<?= $stream['id'] ?>" style="text-decoration:none">
          <div class="card-activity">
            <div class="position-relative">
              <img src="<?= $stream['thumbnail_url'] ?? 'https://placehold.co/400x225/1E1E2F/F15BB5?text=Live' ?>" alt="" class="w-100" style="height:200px;object-fit:cover">
              <span class="position-absolute top-0 start-0 m-2 badge bg-danger"><i class="fas fa-circle me-1"></i>LIVE</span>
              <span class="position-absolute top-0 end-0 m-2 badge bg-dark"><i class="fas fa-eye me-1"></i><?= \Core\Helpers::formatNumber($stream['viewer_count']) ?></span>
            </div>
            <div class="p-3">
              <h5 class="text-white mb-1"><?= htmlspecialchars($stream['title']) ?></h5>
              <p class="text-white-50 small mb-0"><i class="fas fa-user me-1"></i><?= htmlspecialchars($stream['username']) ?></p>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($upcomingStreams)): ?>
    <h2 class="text-accent mb-4 mt-5" data-aos="fade-up"><i class="far fa-calendar-alt me-2"></i>À VENIR</h2>
    <div class="row g-4" data-aos="fade-up">
      <?php foreach ($upcomingStreams as $stream): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card-activity-alt">
          <div class="p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="text-white mb-0"><?= htmlspecialchars($stream['title']) ?></h5>
              <span class="badge bg-secondary">Planifié</span>
            </div>
            <p class="text-white-50 small mb-2"><?= htmlspecialchars($stream['username']) ?></p>
            <p class="text-white-50 small mb-0"><i class="far fa-clock me-1"></i><?= date('d/m/Y H:i', strtotime($stream['scheduled_at'])) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (empty($liveStreams) && empty($upcomingStreams)): ?>
    <div class="text-center py-5" data-aos="fade-up">
      <i class="fas fa-video fa-4x text-white-50 mb-3"></i>
      <h4 class="text-white">Aucun stream pour le moment</h4>
      <p class="text-white-50">Revenez plus tard pour voir les streams en direct et à venir.</p>
    </div>
    <?php endif; ?>
  </div>
</section>
