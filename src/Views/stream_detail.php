<section class="section-padding px-3">
  <div class="container">
    <?php if (isset($notFound) && $notFound): ?>
      <div class="text-center py-5">
        <i class="fas fa-exclamation-triangle fa-4x text-white-50 mb-3"></i>
        <h2 class="text-white">Stream introuvable</h2>
        <p class="text-white-50 mb-4">Ce stream n'existe pas ou n'est plus en direct.</p>
        <a href="/streams" class="btn btn-senex">Voir les streams</a>
      </div>
    <?php else: ?>
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="position-relative">
          <div style="width:100%;aspect-ratio:16/9;background:#000;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:12px">
            <i class="fas fa-broadcast-tower" style="font-size:3rem;color:rgba(255,255,255,0.3)"></i>
            <p class="text-white-50 mb-0">Stream en cours...</p>
            <?php if (isset($stream['stream_key'])): ?>
            <code style="background:rgba(0,0,0,0.5);padding:8px 16px;border-radius:8px;color:#F15BB5;font-size:.85rem"><?= $stream['stream_key'] ?></code>
            <?php endif; ?>
          </div>
        </div>
        <div class="mt-3">
          <h2 class="text-white"><?= htmlspecialchars($stream['title'] ?? '') ?></h2>
          <div class="d-flex align-items-center gap-3 mb-3">
            <span class="badge bg-danger"><i class="fas fa-circle me-1"></i>LIVE</span>
            <span class="text-white-50"><i class="fas fa-eye me-1"></i><?= \Core\Helpers::formatNumber($stream['viewer_count'] ?? 0) ?></span>
          </div>
          <p class="text-white-50"><?= nl2br(htmlspecialchars($stream['description'] ?? '')) ?></p>
        </div>
      </div>
      <div class="col-lg-4">
        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:16px;height:500px;display:flex;flex-direction:column">
          <h5 class="text-white mb-3"><i class="fas fa-comment me-2" style="color:#F15BB5"></i>Chat</h5>
          <div id="publicChatMessages" style="flex:1;overflow-y:auto;margin-bottom:12px;display:flex;flex-direction:column;gap:4px">
            <div style="text-align:center;color:rgba(255,255,255,0.3);padding:40px 0;font-size:.85rem">Connectez-vous pour chatter</div>
          </div>
          <?php if (isset($user) && $user): ?>
          <div class="d-flex gap-2">
            <input type="text" id="publicChatInput" class="form-control" placeholder="Votre message..." style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#fff">
            <button class="btn btn-senex btn-sm" onclick="sendPublicChat()"><i class="fas fa-paper-plane"></i></button>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php if (isset($stream) && !isset($notFound)): ?>
<script src="/assets/js/chat.js"></script>
<script>
  const publicChat = new ChatClient(<?= $stream['id'] ?>, 'publicChatMessages', 'publicChatInput');
  publicChat.start();
  function sendPublicChat() { publicChat.send(); }
</script>
<?php endif; ?>
