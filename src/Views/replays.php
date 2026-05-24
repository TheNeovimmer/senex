<?php

$title = "SENEX - Replays";
ob_start();

?>
<section class="py-5 px-3">
  <div class="container">
    <div class="rounded-5 overflow-hidden text-center py-5 mb-5" data-aos="fade-up" style="border: 2px solid #F15BB5;">
      <h1 class="fw-bold text-white mb-3" style="font-size: clamp(3rem, 6vw, 6rem); letter-spacing: 0.1em;">REPLAYS</h1>
      <p class="fw-bold text-white mb-2" style="font-size: clamp(1.25rem, 2.5vw, 2.25rem);">Watch. Learn. Improve.</p>
      <p class="text-white" style="font-size: clamp(1rem, 1.5vw, 1.5rem);">Relive the best moments and get inspired.</p>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap mb-5" data-aos="fade-up">
      <div class="position-relative" style="max-width: 580px; width: 100%;">
        <div style="width: 100%; height: 73px; background: #1B1D2F; border-radius: 30px; border: 1px solid #F15BB5;"></div>
        <i class="fas fa-search position-absolute top-50 translate-middle-y" style="left: 30px; color: #AD4D9F; font-size: 1.25rem;"></i>
        <span class="position-absolute top-50 translate-middle-y text-white" style="left: 65px; font-size: 1.25rem; opacity: 0.6;">Search replays ; tag or user</span>
      </div>
      <div class="position-relative" style="max-width: 200px; width: 100%;">
        <div style="width: 100%; height: 73px; background: #1B1D2F; border-radius: 30px; border: 1px solid #F15BB5;"></div>
        <span class="position-absolute top-50 translate-middle-y text-white" style="left: 45px; font-size: 1.25rem;">All categories</span>
        <i class="fas fa-chevron-down position-absolute top-50 translate-middle-y" style="right: 20px; color: white; font-size: 0.8rem;"></i>
      </div>
      <div style="width: 73px; height: 73px; background: #1B1D2F; border-radius: 30px; border: 1px solid #F15BB5; display: flex; align-items: center; justify-content: center;">
        <i class="fas fa-sliders-h" style="color: white; font-size: 1.25rem;"></i>
      </div>
    </div>

    <?php
    $replays = [
      [
        'title' => 'Grimpe Vagues',
        'desc' => 'Climb wave-shaped structures, testing your agility and control.',
        'views' => '40k',
        'likes' => '54k',
        'comments' => '1.2k',
        'plays' => '450k',
        'duration' => '15:42'
      ],
      [
        'title' => 'Parcours Maki',
        'desc' => 'An obstacle course that challenges your speed, strength, and coordination.',
        'views' => '40k',
        'likes' => '54k',
        'comments' => '1.2k',
        'plays' => '450k',
        'duration' => '15:42'
      ],
      [
        'title' => 'Labyrinthe Rachid',
        'desc' => 'A maze where you need strategy and orientation to find the way out.',
        'views' => '40k',
        'likes' => '54k',
        'comments' => '1.2k',
        'plays' => '450k',
        'duration' => '15:42'
      ]
    ];
    ?>

    <div class="mx-auto" data-aos="fade-up" style="max-width: 1174px;">
      <?php foreach ($replays as $index => $replay): ?>
      <div class="d-flex flex-column flex-lg-row align-items-start gap-4 mb-5 pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
        <div class="position-relative flex-shrink-0" style="width: 100%; max-width: 406px;">
          <img src="https://placehold.co/406x266" alt="<?= $replay['title'] ?>" class="w-100 rounded-4">
          <div class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center" style="width: 96px; height: 96px;">
            <i class="fas fa-play" style="color: white; font-size: 3rem;"></i>
          </div>
          <span class="position-absolute bottom-0 end-0 text-white m-2" style="font-size: 1.25rem;"><?= $replay['duration'] ?></span>
        </div>
        <div class="flex-grow-1">
          <h4 class="fw-bold mb-1" style="color: #F15BB5; font-size: 1.25rem;"><?= $replay['title'] ?></h4>
          <p class="text-white mb-3" style="font-size: 1.25rem; opacity: 0.8;"><?= $replay['desc'] ?></p>
          <div class="d-flex align-items-center gap-4">
            <div class="d-flex align-items-center gap-2">
              <i class="fas fa-eye" style="color: white; font-size: 1rem; opacity: 0.6;"></i>
              <span class="text-white" style="font-size: 0.9rem; letter-spacing: 0.15em;"><?= $replay['views'] ?></span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="fas fa-heart" style="color: #F15BB5; font-size: 1rem;"></i>
              <span class="text-white" style="font-size: 0.9rem; letter-spacing: 0.15em;"><?= $replay['likes'] ?></span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="fas fa-comment" style="color: white; font-size: 1rem; opacity: 0.6;"></i>
              <span class="text-white" style="font-size: 0.9rem; letter-spacing: 0.15em;"><?= $replay['comments'] ?></span>
            </div>
            <div class="d-flex align-items-center gap-1">
              <i class="fas fa-play" style="color: white; font-size: 0.8rem; opacity: 0.6;"></i>
              <span class="text-white" style="font-size: 0.9rem; letter-spacing: 0.15em;"><?= $replay['plays'] ?></span>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="text-white" style="font-size: 0.9rem; letter-spacing: 0.15em; opacity: 0.6;">2 days ago</span>
            <i class="fas fa-ellipsis-v" style="color: rgba(255,255,255,0.3); cursor: pointer;"></i>
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
