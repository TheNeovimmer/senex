<?php $title = 'Live Studio'; ?>
<div class="streamer-live-view">
    <div class="video-section">
        <div class="stream-controls">
            <span class="status-dot"></span><strong style="color:#fff">EN DIRECT</strong>
            <span style="color:rgba(255,255,255,0.5);font-size:.85rem"><?= htmlspecialchars($stream['title']) ?></span>
            <div class="ms-auto d-flex gap-2">
                <?php if ($activeChallenge): ?>
                    <button class="btn-senex btn-senex-sm btn-senex-danger" onclick="alert('Défi en cours...')"><i class="fas fa-stop"></i> Arrêter le défi</button>
                <?php else: ?>
                    <a href="/streamer/challenges" class="btn-senex-outline btn-senex-sm"><i class="fas fa-plus"></i> Lancer un défi</a>
                <?php endif; ?>
                <a href="/streamer/end-live/<?= $stream['id'] ?>" class="btn-senex btn-senex-danger btn-senex-sm" onclick="return confirm('Terminer le stream?')"><i class="fas fa-power-off"></i> End Stream</a>
            </div>
        </div>

        <div class="video-player" id="streamPlayer">
            <div class="placeholder-text">
                <i class="fas fa-broadcast-tower"></i>
                <p>Stream prêt. Utilisez OBS/Streamlabs avec cette clé :</p>
                <code style="background:rgba(0,0,0,0.5);padding:8px 16px;border-radius:8px;color:#F15BB5;font-size:.9rem"><?= $stream['stream_key'] ?></code>
                <button class="btn-senex btn-senex-sm mt-3" onclick="copyToClipboard('<?= $stream['stream_key'] ?>')"><i class="fas fa-copy"></i> Copier</button>
            </div>
        </div>

        <?php if ($activeChallenge): ?>
            <div class="active-challenge-bar">
                <div class="challenge-info">
                    <i class="fas fa-trophy" style="color:#FFD700;font-size:1.2rem"></i>
                    <div>
                        <h6><?= htmlspecialchars($activeChallenge['title']) ?></h6>
                        <small><?= $activeChallenge['difficulty'] ?> · <?= \Core\Helpers::formatDuration($activeChallenge['duration_seconds']) ?></small>
                    </div>
                </div>
                <button class="btn-senex btn-senex-sm btn-senex-success"><i class="fas fa-check"></i> Complété</button>
            </div>
        <?php endif; ?>
    </div>

    <div class="chat-section">
        <div class="chat-header">
            <h6><i class="fas fa-comment me-2" style="color:#F15BB5"></i>Chat en direct</h6>
            <span id="chatCount" style="color:rgba(255,255,255,0.4);font-size:.8rem">0</span>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div style="text-align:center;color:rgba(255,255,255,0.3);padding:40px 20px">
                <i class="fas fa-comments" style="font-size:2rem;margin-bottom:12px;display:block"></i>
                <p style="font-size:.85rem">Les messages apparaîtront ici</p>
            </div>
        </div>
        <div class="chat-input">
            <input type="text" id="chatInput" placeholder="Tapez votre message..." autocomplete="off">
            <button class="btn-senex btn-senex-sm" onclick="sendChat()"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<script src="/assets/js/chat.js"></script>
<script src="/assets/js/player.js"></script>
<script>
    const player = new StreamPlayer('streamPlayer', '<?= $stream['stream_key'] ?>');
    player.init();
    const chat = new ChatClient(<?= $stream['id'] ?>, 'chatMessages', 'chatInput');
    chat.start();
    function sendChat() { chat.send(); }
</script>
