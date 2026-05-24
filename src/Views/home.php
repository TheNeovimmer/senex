<section class="hero-section px-3">
  <div class="container">
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-10 text-center">
        <h1 class="hero-heading text-white mb-4">
          ENTER THE SENEX WHERE REAL LIFE BECOMES THE SHOW
        </h1>
        <p class="hero-subtitle text-white mb-5 mx-auto hero-subtitle-max">
          Live challenges. real reactions. Total immersion.<br>Senex is the ultimate interactive streaming experience
        </p>
        <a href="/next" class="btn btn-senex btn-senex-lg btn-round-84 ls-md">DISCOVER</a>
      </div>
    </div>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <div class="row align-items-center g-5" data-aos="fade-up">
      <div class="col-lg-7">
        <div class="text-center p-5 card-bordered radius-md">
          <h2 class="text-white fw-bold mb-4 heading-sm ls-md">About Us</h2>
          <p class="text-white fs-5 lh-base mx-auto ls-sm about-desc-max">
            SENEX is more than just a platform – it's a community driven by challenges and growth. Join us to push your limits, embrace new experiences, and connect with a passionate community.
          </p>
          <a href="/aboutus" class="btn btn-outline-senex mt-4 join-us-btn">join us</a>
        </div>
      </div>
      <div class="col-lg-5 text-center">
        <img src="https://placehold.co/403x484" alt="About SENEX" class="w-100 rounded-4 border-accent about-img-max">
      </div>
    </div>
  </div>
</section>

<?php if (!empty($liveStreams)): ?>
<section class="section-padding px-3">
  <div class="container">
    <h2 class="text-center mb-5 activity-section-title" data-aos="fade-up">
      <span class="text-white">🔥 EN DIRECT </span>
      <span class="text-accent">MAINTENANT</span>
    </h2>
    <div class="row g-4 justify-content-center" data-aos="fade-up">
      <?php foreach (array_slice($liveStreams, 0, 3) as $stream): ?>
      <div class="col-md-6 col-lg-4">
        <a href="/stream/<?= $stream['id'] ?>" style="text-decoration:none">
          <div class="card-activity">
            <div class="position-relative">
              <img src="<?= $stream['thumbnail_url'] ?? 'https://placehold.co/400x225/1E1E2F/F15BB5?text=Live' ?>" alt="" class="w-100" style="height:200px;object-fit:cover">
              <span class="position-absolute top-0 start-0 m-2 badge bg-danger"><i class="fas fa-circle me-1"></i> LIVE</span>
            </div>
            <div class="p-4">
              <h5 class="text-white mb-1"><?= htmlspecialchars($stream['title']) ?></h5>
              <p class="text-white-50 small mb-0"><?= htmlspecialchars($stream['username']) ?> · <i class="fas fa-eye"></i> <?= \Core\Helpers::formatNumber($stream['viewer_count']) ?></p>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4" data-aos="fade-up">
      <a href="/streams" class="btn btn-senex px-5 py-3 fs-5 btn-round-xl">SEE ALL STREAMS</a>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($activeChallenges)): ?>
<section class="section-padding px-3">
  <div class="container">
    <h2 class="text-center mb-5 activity-section-title" data-aos="fade-up">
      <span class="text-white">DÉFIS </span>
      <span class="text-accent">ACTIFS</span>
    </h2>
    <div class="row g-4 justify-content-center" data-aos="fade-up">
      <?php foreach (array_slice($activeChallenges, 0, 3) as $challenge): ?>
      <div class="col-md-6 col-lg-4">
        <div class="<?= $loop->index ?? 0 === 0 ? 'card-activity' : 'card-activity-alt' ?>">
          <div class="p-4">
            <span class="badge mb-2" style="background:<?= $challenge['difficulty'] === 'easy' ? '#4CAF50' : ($challenge['difficulty'] === 'medium' ? '#FF9800' : '#F44336') ?>"><?= $challenge['difficulty'] ?></span>
            <h5 class="text-white mb-2"><?= htmlspecialchars($challenge['title']) ?></h5>
            <p class="text-white-50 small mb-2"><?= \Core\Helpers::truncate($challenge['description'] ?? '', 100) ?></p>
            <span class="text-accent small"><i class="fas fa-star me-1"></i><?= $challenge['xp_reward'] ?> XP</span>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4" data-aos="fade-up">
      <a href="/dashboard/challenges" class="btn btn-senex px-5 py-3 fs-5 btn-round-xl">JOIN CHALLENGES</a>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section-padding px-3">
  <div class="container-fluid px-0" data-aos="fade-up">
    <div class="position-relative overflow-hidden rounded-4 text-center card-bordered hero-overlay-bg">
      <div class="py-5 px-3">
        <h2 class="display-4 fw-bold mb-3 text-accent ls-md">RELIVE THE WILDEST DARES</h2>
        <p class="text-white fs-5 mb-5 ls-lg">the best moments, anytime you want</p>
        <div class="d-flex justify-content-center align-items-end gap-2 flex-wrap mb-5">
          <?php if (!empty($recentReplays)): ?>
            <?php foreach (array_slice($recentReplays, 0, 5) as $i => $replay): ?>
            <a href="/replay/<?= $replay['id'] ?>">
              <img src="<?= $replay['thumbnail_url'] ?? 'https://placehold.co/' . ([158,217,350,217,158][$i] ?? 158) . 'x' . ([297,408,502,408,299][$i] ?? 300) . '/1E1E2F/F15BB5?text=Replay' ?>" alt="<?= htmlspecialchars($replay['title']) ?>" class="replay-stagger-img" style="width: clamp(80px, 10vw, <?= [158,217,350,217,158][$i] ?? 158 ?>px);">
            </a>
            <?php endforeach; ?>
          <?php else: ?>
          <img src="https://placehold.co/158x297" alt="" class="replay-stagger-img" style="width: clamp(80px, 10vw, 158px);">
          <img src="https://placehold.co/217x408" alt="" class="replay-stagger-img" style="width: clamp(110px, 14vw, 217px);">
          <img src="https://placehold.co/350x502" alt="" class="replay-stagger-img" style="width: clamp(160px, 20vw, 350px);">
          <img src="https://placehold.co/217x408" alt="" class="replay-stagger-img" style="width: clamp(110px, 14vw, 217px);">
          <img src="https://placehold.co/158x299" alt="" class="replay-stagger-img" style="width: clamp(80px, 10vw, 158px);">
          <?php endif; ?>
        </div>
        <a href="/replays" class="btn btn-senex px-5 py-3 fs-5 btn-round-xl ls-md">WATCH ALL REPLAYS</a>
      </div>
    </div>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <h2 class="section-title text-center mb-5 text-capitalize" data-aos="fade-up">the best pricing plans</h2>
    <div class="row g-4 justify-content-center align-items-center" data-aos="fade-up">
      <div class="col-md-6 col-lg-4">
        <div class="card-pricing">
          <h3 class="fw-bold text-white fs-2 text-capitalize mb-4">Basic Plan</h3>
          <p class="text-white mb-4">
            <span class="fs-1 fw-normal">$9.99</span><span class="fs-5">/month</span>
          </p>
          <p class="text-white-50 mb-5 ls-lg pricing-features">
            .Access to basic challenges<br>.community support<br>.challenge per month<br>.limited rewards
          </p>
          <a href="#" class="btn btn-outline-senex fs-4 px-5 py-3 w-100">Get started</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card-pricing card-pricing-highlighted">
          <h3 class="fw-bold text-white fs-2 text-capitalize mb-4">pro plan</h3>
          <p class="text-white mb-4">
            <span class="fs-1 fw-normal">$19.99</span><span class="fs-5">/month</span>
          </p>
          <p class="text-white-50 mb-5 ls-lg pricing-features">
            .Access to basic challenges<br>.community support<br>.challenge per month<br>.limited rewards
          </p>
          <a href="#" class="btn btn-outline-senex fs-4 px-5 py-3 w-100 border-accent">Get started</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card-pricing">
          <h3 class="fw-bold text-white fs-2 text-capitalize mb-4">Basic Plan</h3>
          <p class="text-white mb-4">
            <span class="fs-1 fw-normal">$29.99</span><span class="fs-5">/month</span>
          </p>
          <p class="text-white-50 mb-5 ls-lg pricing-features">
            .Access to basic challenges<br>.community support<br>.challenge per month<br>.limited rewards
          </p>
          <a href="#" class="btn btn-outline-senex fs-4 px-5 py-3 w-100">Get started</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <div class="row align-items-center justify-content-between g-4" data-aos="fade-up">
      <div class="col-4 col-md-2 text-center">
        <i class="fab fa-twitch fa-3x partner-logo"></i>
      </div>
      <div class="col-4 col-md-2 text-center">
        <i class="fab fa-spotify fa-3x partner-logo"></i>
      </div>
      <div class="col-4 col-md-2 text-center">
        <i class="fab fa-discord fa-3x partner-logo"></i>
      </div>
      <div class="col-4 col-md-2 text-center">
        <i class="fab fa-youtube fa-3x partner-logo"></i>
      </div>
      <div class="col-4 col-md-2 text-center">
        <i class="fab fa-tiktok fa-3x partner-logo"></i>
      </div>
    </div>
  </div>
</section>

