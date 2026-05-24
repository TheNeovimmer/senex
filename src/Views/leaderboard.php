<section class="section-padding px-3">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h1 class="fw-bold text-white mb-3 heading-md"><i class="fas fa-trophy me-2" style="color:#FFD700"></i>CLASSEMENT</h1>
    </div>

    <?php if (empty($entries)): ?>
    <div class="text-center py-5" data-aos="fade-up">
      <i class="fas fa-trophy fa-4x text-white-50 mb-3"></i>
      <h4 class="text-white">Aucune participation</h4>
      <p class="text-white-50">Personne n'a encore participé à ce défi.</p>
    </div>
    <?php else: ?>
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-8">
        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;overflow:hidden">
          <table class="table table-dark table-striped mb-0" style="background:transparent">
            <thead>
              <tr>
                <th>#</th>
                <th>Utilisateur</th>
                <th>Score</th>
                <th>Temps</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php $rank = 1; ?>
              <?php foreach ($entries as $entry): ?>
              <tr>
                <td>
                  <?php if ($rank === 1): ?>🥇
                  <?php elseif ($rank === 2): ?>🥈
                  <?php elseif ($rank === 3): ?>🥉
                  <?php else: ?><span class="text-white-50"><?= $rank ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img src="<?= $entry['avatar_url'] ?? 'https://placehold.co/32x32/1E1E2F/F15BB5?text=' . ($entry['username'][0] ?? 'U') ?>" alt="" style="width:32px;height:32px;border-radius:50%;object-fit:cover">
                    <span class="text-white"><?= htmlspecialchars($entry['username']) ?></span>
                  </div>
                </td>
                <td><strong style="color:#FFD700"><?= $entry['score'] ?></strong></td>
                <td class="text-white-50"><?= \Core\Helpers::formatDuration($entry['time_taken_seconds'] ?? 0) ?></td>
                <td class="text-white-50"><?= date('d/m/Y', strtotime($entry['created_at'] ?? $entry['started_at'])) ?></td>
              </tr>
              <?php $rank++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
