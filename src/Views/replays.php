<?php

$title = "SENEX - Replays";
ob_start();

?>
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

    <?php
    $replays = [
      [
        'title' => 'Grimpe Vagues',
        'desc' => 'Climb wave-shaped structures, testing your agility and control.',
        'views' => '40k', 'likes' => '54k', 'comments' => '1.2k', 'plays' => '450k', 'duration' => '15:42'
      ],
      [
        'title' => 'Parcours Maki',
        'desc' => 'An obstacle course that challenges your speed, strength, and coordination.',
        'views' => '40k', 'likes' => '54k', 'comments' => '1.2k', 'plays' => '450k', 'duration' => '15:42'
      ],
      [
        'title' => 'Labyrinthe Rachid',
        'desc' => 'A maze where you need strategy and orientation to find the way out.',
        'views' => '40k', 'likes' => '54k', 'comments' => '1.2k', 'plays' => '450k', 'duration' => '15:42'
      ]
    ];
    ?>

    <div class="mx-auto mw-1174" data-aos="fade-up">
      <?php foreach ($replays as $replay): ?>
      <div class="d-flex flex-column flex-lg-row align-items-start gap-4 mb-5 pb-4 section-divider">
        <div class="replay-thumb-wrapper">
          <img src="https://placehold.co/406x266" alt="<?= $replay['title'] ?>" class="w-100 rounded-4">
          <div class="replay-play-overlay">
            <i class="fas fa-play text-white fs-3"></i>
          </div>
          <span class="replay-duration"><?= $replay['duration'] ?></span>
        </div>
        <div class="flex-grow-1">
          <h4 class="replay-title"><?= $replay['title'] ?></h4>
          <p class="replay-desc"><?= $replay['desc'] ?></p>
          <div class="replay-stats">
            <div class="replay-stat-item">
              <i class="fas fa-eye replay-stat-icon"></i>
              <span class="replay-stat-label"><?= $replay['views'] ?></span>
            </div>
            <div class="replay-stat-item">
              <i class="fas fa-heart text-accent replay-heart-icon"></i>
              <span class="replay-stat-label"><?= $replay['likes'] ?></span>
            </div>
            <div class="replay-stat-item">
              <i class="fas fa-comment replay-stat-icon"></i>
              <span class="replay-stat-label"><?= $replay['comments'] ?></span>
            </div>
            <div class="replay-stat-item">
              <i class="fas fa-play replay-stat-icon replay-play-icon-sm"></i>
              <span class="replay-stat-label"><?= $replay['plays'] ?></span>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="replay-timestamp">2 days ago</span>
            <i class="fas fa-ellipsis-v ellipsis-btn"></i>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php

$content = ob_get_clean();
require __DIR__ . '/base.php';
