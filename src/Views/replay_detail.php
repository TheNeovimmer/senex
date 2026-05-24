<section class="section-padding px-3">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-8">
        <div style="width:100%;aspect-ratio:16/9;background:#000;border-radius:12px;display:flex;align-items:center;justify-content:center">
          <video style="width:100%;height:100%;object-fit:contain" controls>
            <source src="<?= htmlspecialchars($replay['video_url'] ?? '') ?>" type="video/mp4">
            <p class="text-white-50">Replay disponible. Vidéo externe nécessaire.</p>
          </video>
        </div>
        <div class="mt-3">
          <h2 class="text-white"><?= htmlspecialchars($replay['title']) ?></h2>
          <div class="d-flex align-items-center gap-3 mb-3">
            <span class="text-white-50"><i class="fas fa-eye me-1"></i><?= \Core\Helpers::formatNumber($replay['view_count'] ?? 0) ?></span>
            <span class="text-white-50"><i class="fas fa-clock me-1"></i><?= \Core\Helpers::formatDuration($replay['duration_seconds'] ?? 0) ?></span>
            <span class="text-white-50"><?= date('d/m/Y', strtotime($replay['created_at'])) ?></span>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:16px">
          <h5 class="text-white mb-3">Détails du replay</h5>
          <p class="text-white-50 small mb-2"><?= htmlspecialchars($replay['description'] ?? '') ?></p>
          <a href="/streams" class="btn btn-senex btn-sm w-100 mt-3"><i class="fas fa-arrow-left me-2"></i>Voir les streams</a>
        </div>
      </div>
    </div>
  </div>
</section>
