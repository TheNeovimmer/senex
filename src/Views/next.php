<section class="section-padding px-3">
  <div class="container">
    <div class="hero-bordered text-center p-5" data-aos="fade-up">
      <div class="position-relative z-1">
        <h1 class="fw-bold text-white mb-3 heading-lg ls-lg text-shadow-hero">
          ARE YOU READY FOR THE NEXT DARE?
        </h1>
        <p class="fw-bold text-white mb-4 heading-sm">watch it live . vote . influence the outcome</p>
        <p class="next-dare-countdown-label mb-4">Next dare begins in</p>
        <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap mb-4">
          <div class="countdown-box"><span class="countdown-digit text-accent">0</span></div>
          <div class="countdown-box"><span class="countdown-digit text-purple">5</span></div>
          <span class="countdown-separator">:</span>
          <div class="countdown-box"><span class="countdown-digit text-accent">3</span></div>
          <div class="countdown-box"><span class="countdown-digit text-accent">3</span></div>
          <span class="countdown-separator">:</span>
          <div class="countdown-box"><span class="countdown-digit text-purple">5</span></div>
          <div class="countdown-box"><span class="countdown-digit text-accent">9</span></div>
        </div>
        <div class="d-flex justify-content-center gap-4 flex-wrap">
          <a href="#" class="btn btn-senex px-5 py-3 btn-round-xl btn-hero-cta">PARTICIPATE</a>
          <a href="#" class="btn btn-senex px-5 py-3 btn-round-xl btn-hero-cta">WATCH</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold text-accent heading-md ls-lg text-capitalize" data-aos="fade-up">
      An unexpected challenge is live.<br>Will you step up or just watch?
    </h2>
<?php if (!empty($upcomingChallenges)): $first = $upcomingChallenges[0]; ?>
    <div class="row align-items-center g-5" data-aos="fade-up">
      <div class="col-lg-6 text-center">
        <img src="https://placehold.co/594x549" alt="<?= htmlspecialchars($first['title']) ?>" class="w-100 rounded-5 border-accent mw-594">
      </div>
      <div class="col-lg-6">
        <p class="challenge-subtitle ls-lg"><?= htmlspecialchars($first['username']) ?> · <?= $first['xp_reward'] ?> XP</p>
        <div class="d-flex align-items-center gap-2 flex-wrap mb-4">
          <div class="countdown-box"><span class="countdown-digit text-accent">-</span></div>
          <div class="countdown-box"><span class="countdown-digit text-purple">-</span></div>
          <span class="countdown-separator">:</span>
          <div class="countdown-box"><span class="countdown-digit text-accent">-</span></div>
          <div class="countdown-box"><span class="countdown-digit text-accent">-</span></div>
          <span class="countdown-separator">:</span>
          <div class="countdown-box"><span class="countdown-digit text-purple">-</span></div>
          <div class="countdown-box"><span class="countdown-digit text-accent">-</span></div>
        </div>
        <p class="fw-bold text-white mb-1 ls-lg fs-25">Real-life challenge</p>
        <h3 class="fw-bold mb-3 text-purple ls-lg challenge-title"><?= strtoupper(htmlspecialchars($first['title'])) ?></h3>
        <p class="challenge-desc mb-4">
          &ldquo;<?= htmlspecialchars($first['description'] ?? 'No description available.') ?>&rdquo;
        </p>
        <div class="d-flex gap-3 flex-wrap">
          <a href="/dashboard/challenge/start/<?= $first['id'] ?>" class="btn btn-senex btn-round-68 btn-challenge">PARTICIPATE</a>
          <a href="/streams" class="btn btn-senex btn-round-68 btn-challenge-wide">SEE MORE</a>
        </div>
      </div>
    </div>
<?php endif; ?>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
<?php if (!empty($upcomingChallenges) && isset($upcomingChallenges[1])): $second = $upcomingChallenges[1]; ?>
    <div class="row align-items-center g-5" data-aos="fade-up">
      <div class="col-lg-6">
        <p class="challenge-subtitle ls-lg"><?= htmlspecialchars($second['username']) ?> · <?= $second['xp_reward'] ?> XP</p>
        <div class="d-flex align-items-center gap-2 flex-wrap mb-4">
          <div class="countdown-box"><span class="countdown-digit text-accent">-</span></div>
          <div class="countdown-box"><span class="countdown-digit text-purple">-</span></div>
          <span class="countdown-separator">:</span>
          <div class="countdown-box"><span class="countdown-digit text-accent">-</span></div>
          <div class="countdown-box"><span class="countdown-digit text-accent">-</span></div>
          <span class="countdown-separator">:</span>
          <div class="countdown-box"><span class="countdown-digit text-purple">-</span></div>
          <div class="countdown-box"><span class="countdown-digit text-accent">-</span></div>
        </div>
        <p class="fw-bold text-white mb-1 ls-lg fs-25">Real-life challenge</p>
        <h3 class="fw-bold mb-3 text-purple ls-lg challenge-title"><?= strtoupper(htmlspecialchars($second['title'])) ?></h3>
        <p class="challenge-desc mb-4">
          &ldquo;<?= htmlspecialchars($second['description'] ?? 'No description available.') ?>&rdquo;
        </p>
        <div class="d-flex gap-3 flex-wrap">
          <a href="/dashboard/challenge/start/<?= $second['id'] ?>" class="btn btn-senex btn-round-68 btn-challenge">PARTICIPATE</a>
          <a href="/streams" class="btn btn-senex btn-round-68 btn-challenge-wide">SEE MORE</a>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <img src="https://placehold.co/594x549" alt="<?= htmlspecialchars($second['title']) ?>" class="w-100 rounded-5 border-accent mw-594">
      </div>
    </div>
<?php endif; ?>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <div class="card-bordered-lg rounded-5 p-5 text-center" data-aos="fade-up">
      <h2 class="fw-bold text-white mb-3 heading-md ls-2xl">
        VOTE NOW<br>AND<br>SHAPE THE DARE
      </h2>
      <p class="fw-bold text-white mb-4 heading-sm">Urban climbing challenge</p>
      <div class="mb-4 mx-auto mw-600">
        <div class="vote-idea-box text-start">
          <p class="vote-idea-text">write your idea dare</p>
        </div>
      </div>
      <div class="mx-auto mw-600">
        <div class="mb-3 text-start">
          <span class="progress-label">Fun</span>
          <div class="progress-bar-senex progress-bg-vote" style="background: linear-gradient(90deg, #FFFDFD 58%, #66376B 100%);">
            <div class="progress-bar-fill" style="width: 58%;"></div>
          </div>
        </div>
        <div class="mb-3 text-start">
          <span class="progress-label">Creativity</span>
          <div class="progress-bar-senex progress-bg-vote" style="background: linear-gradient(90deg, #FFFDFD 45%, #66376B 100%);">
            <div class="progress-bar-fill" style="width: 77%;"></div>
          </div>
        </div>
        <div class="mb-4 text-start">
          <span class="progress-label">difficulty</span>
          <div class="progress-bar-senex progress-bg-vote" style="background: linear-gradient(90deg, #FFFDFD 48%, #66376B 100%);">
            <div class="progress-bar-fill" style="width: 32%;"></div>
          </div>
        </div>
      </div>
      <a href="#" class="btn btn-senex px-5 py-3 btn-round-xl btn-hero-cta">PARTICIPATE</a>
    </div>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold text-accent heading-md" data-aos="fade-up">Dare timeline</h2>
    <div class="row g-4 align-items-stretch justify-content-center" data-aos="fade-up">
      <div class="col-lg-7">
        <div class="card-calendar h-100 p-4">
          <div class="d-flex justify-content-center align-items-center gap-4 mb-4">
            <div class="calendar-nav-btn"><i class="fas fa-chevron-left calendar-nav-icon"></i></div>
            <h4 class="calendar-month-year">June <span class="text-accent">2026</span></h4>
            <div class="calendar-nav-btn"><i class="fas fa-chevron-right calendar-nav-icon"></i></div>
          </div>
          <div class="row g-2 text-center mb-3">
            <div class="col"><span class="calendar-day">MON</span></div>
            <div class="col"><span class="calendar-day">TUE</span></div>
            <div class="col"><span class="calendar-day">WED</span></div>
            <div class="col"><span class="calendar-day">THU</span></div>
            <div class="col"><span class="calendar-day">FRI</span></div>
            <div class="col"><span class="calendar-day-weekend">SUN</span></div>
            <div class="col"><span class="calendar-day-weekend">SAT</span></div>
          </div>
          <?php
          $weeks = [
            [1,2,3,4,5,6,7],
            [8,9,10,11,12,13,14],
            [15,16,17,18,19,20,21],
            [22,23,24,25,26,27,28]
          ];
          foreach ($weeks as $week):
          ?>
          <div class="row g-2 mb-2 text-center">
            <?php foreach ($week as $day):
              $isWeekend = $day <= 7 || in_array($day, [13,14,20,21,27,28]);
              $isActive = $day === 11;
            ?>
            <div class="col">
              <span class="<?= $isActive ? 'calendar-day-active' : '' ?> <?= $isWeekend ? 'calendar-day-weekend' : 'calendar-day' ?> <?= $day > 7 && !$isActive ? 'text-muted' : '' ?>">
                <?= $day ?>
              </span>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card-date-detail d-flex flex-column">
          <div class="d-flex justify-content-center align-items-end gap-3 mb-4">
            <div>
              <p class="date-day ls-xs">TUESDAY</p>
              <p class="date-number ls-xs">11</p>
            </div>
            <div>
              <p class="date-month ls-xs">JUNE</p>
              <p class="text-muted date-year ls-xs">2026</p>
            </div>
          </div>
          <div class="card-date-description mb-4 flex-grow-1 d-flex align-items-center">
            <p class="text-white mb-0 text-center ls-sm challenge-desc">Take on exciting challenges, push your limits, and earn rewards</p>
          </div>
          <a href="#" class="btn btn-senex w-100 py-3 btn-round-xl btn-hero-cta">DISCOVER</a>
        </div>
      </div>
    </div>
  </div>
</section>

