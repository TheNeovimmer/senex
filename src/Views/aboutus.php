<?php

$title = "SENEX - About Us";
ob_start();

?>
<section class="section-padding px-3">
  <div class="container">
    <div class="hero-about-wrapper p-5" data-aos="fade-up">
      <div class="row align-items-center g-5">
        <div class="col-lg-7 text-center">
          <h1 class="fw-bold text-accent heading-lg">ABOUT US</h1>
          <h2 class="fw-bold text-white heading-lg">SENEX</h2>
          <p class="fw-medium text-white mb-4 ls-lg heading-sm">
            Reinventing Live Streaming,<br>One Dare at a Time
          </p>
          <a href="/contact" class="btn btn-outline-senex py-3 px-5 radius-md about-hero-btn">JOIN US</a>
        </div>
        <div class="col-lg-5 text-center">
          <img src="https://placehold.co/529x594" alt="SENEX" class="w-100 rounded-4 border-accent mw-529">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <h2 class="fw-bold text-center mb-4 text-accent heading-lg" data-aos="fade-up">OUR JOURNEY</h2>
    <p class="text-white text-center mx-auto heading-sm mw-1030" data-aos="fade-up">
      Started as a bold idea in 2026, senex has grown into a creative movement. With a passionate team and an ever-growing community, we're redefining what live streaming means — one dare at a time.
    </p>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <div class="row g-5 justify-content-center" data-aos="fade-up">
      <div class="col-md-6">
        <div class="card-mission-vision mv-card">
          <i class="fas fa-bullseye mv-icon mv-icon-bullseye"></i>
          <h3 class="mv-heading text-accent">OUR MISSION</h3>
          <p class="text-white lh-base ls-xs mv-text">
            senex is a bold streaming platform offering curated live content, from real-life challenges to entertainment-packed streams. We empower viewers to explore, feel, and interact.
          </p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card-mission-vision mv-card">
          <i class="fas fa-eye mv-icon mv-icon-eye"></i>
          <h3 class="mv-heading text-accent">OUR VISION</h3>
          <p class="text-white lh-base mv-text">
            To become the leading immersive live-streaming platform where daring meets authenticity.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <h2 class="fw-bold text-center mb-5 text-accent heading-lg" data-aos="fade-up">OUR VALUES</h2>
    <div class="row g-4 justify-content-center" data-aos="fade-up">
      <div class="col-lg-6">
        <div class="value-block d-flex align-items-start gap-4">
          <div class="value-icon-circle flex-shrink-0">
            <i class="fas fa-users text-accent value-icon-lg"></i>
          </div>
          <div>
            <h4 class="fw-bold text-white heading-sm">Community:</h4>
            <p class="value-text">We believe in the power of collaboration. Together, we can achieve great things.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="value-block d-flex align-items-start gap-4">
          <div class="value-icon-circle flex-shrink-0">
            <i class="fas fa-star text-accent value-icon-lg"></i>
          </div>
          <div>
            <h4 class="fw-bold text-white heading-sm">Excellence:</h4>
            <p class="value-text">We strive for excellence in everything we do.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="value-block d-flex align-items-start gap-4">
          <div class="value-icon-circle flex-shrink-0">
            <i class="fas fa-lightbulb text-accent value-icon-lg"></i>
          </div>
          <div>
            <h4 class="fw-bold text-white heading-sm">Innovation:</h4>
            <p class="value-text">We encourage creativity and new ideas to drive progress.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="value-block d-flex align-items-start gap-4">
          <div class="value-icon-circle flex-shrink-0">
            <i class="fas fa-heart text-accent value-icon-lg"></i>
          </div>
          <div>
            <h4 class="fw-bold text-white heading-sm">Passion:</h4>
            <p class="value-text">We are passionate about what we create and the impact it has on our community.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <div class="card-stat d-flex align-items-center justify-content-center flex-wrap gap-5 py-4 px-5" data-aos="fade-up">
      <div class="d-flex align-items-center gap-2">
        <i class="fas fa-users text-accent stat-icon"></i>
        <div>
          <p class="stat-number-gradient">250k</p>
          <p class="stat-label">Active members</p>
        </div>
      </div>
      <div class="divider-vertical"></div>
      <div class="d-flex align-items-center gap-2">
        <i class="fas fa-gamepad text-accent stat-icon"></i>
        <div>
          <p class="stat-number-gradient">100k</p>
          <p class="stat-label">Games played</p>
        </div>
      </div>
      <div class="divider-vertical"></div>
      <div class="d-flex align-items-center gap-2">
        <i class="fas fa-trophy text-accent stat-icon"></i>
        <div>
          <p class="stat-number-gradient">100k</p>
          <p class="stat-label">Paid Represented</p>
        </div>
      </div>
      <div class="divider-vertical"></div>
      <div class="d-flex align-items-center gap-2">
        <i class="fas fa-flag-checkered text-accent stat-icon"></i>
        <div>
          <p class="stat-number-gradient">100k</p>
          <p class="stat-label">Challenges completed</p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php

$content = ob_get_clean();
require __DIR__ . '/base.php';
