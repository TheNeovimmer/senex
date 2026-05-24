class StreamPlayer {
    constructor(containerId, streamKey) {
        this.container = document.getElementById(containerId);
        this.streamKey = streamKey;
    }

    init() {
        this.showPlaceholder();
    }

    showPlaceholder() {
        if (!this.container) return;
        this.container.innerHTML = `
            <div class="placeholder-text">
                <i class="fas fa-broadcast-tower"></i>
                <p>Stream prêt. Utilisez votre logiciel de streaming (OBS, Streamlabs) avec la clé suivante :</p>
                <code style="background:rgba(0,0,0,0.5);padding:8px 16px;border-radius:8px;color:#F15BB5;font-size:.9rem;">
                    ${this.streamKey}
                </code>
                <button class="btn-senex btn-senex-sm mt-3" onclick="copyToClipboard('${this.streamKey}')">
                    <i class="fas fa-copy"></i> Copier la clé
                </button>
            </div>
        `;
    }
}

class ReplayPlayer {
    constructor(containerId, videoUrl) {
        this.container = document.getElementById(containerId);
        this.videoUrl = videoUrl;
    }

    init() {
        if (!this.container) return;
        this.container.innerHTML = `
            <video style="width:100%;height:100%;object-fit:contain;background:#000;" controls autoplay>
                <source src="${this.videoUrl}" type="video/mp4">
            </video>
        `;
    }
}
