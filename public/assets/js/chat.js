class ChatClient {
    constructor(streamId, containerId, inputId) {
        this.streamId = streamId;
        this.container = document.getElementById(containerId);
        this.input = document.getElementById(inputId);
        this.lastId = 0;
        this.pollInterval = null;
        if (this.input) {
            this.input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.send();
            });
        }
    }

    start() {
        this.poll();
        this.pollInterval = setInterval(() => this.poll(), 2000);
    }

    stop() {
        if (this.pollInterval) clearInterval(this.pollInterval);
    }

    async send() {
        const msg = this.input.value.trim();
        if (!msg) return;
        this.input.value = '';
        try {
            await fetch('/api/chat/send', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({stream_id: this.streamId, message: msg})
            });
        } catch (e) { console.error('Chat send error:', e); }
    }

    async poll() {
        try {
            const res = await fetch(`/api/chat/messages?stream_id=${this.streamId}&after=${this.lastId}`);
            const data = await res.json();
            if (data.messages) {
                data.messages.forEach(m => this.addMessage(m));
                this.lastId = data.last_id || this.lastId;
            }
        } catch (e) { /* silent */ }
    }

    addMessage(msg) {
        const div = document.createElement('div');
        div.className = 'chat-message';
        div.innerHTML = `<strong>${escapeHtml(msg.username)}</strong>: ${escapeHtml(msg.message)}`;
        this.container.appendChild(div);
        this.container.scrollTop = this.container.scrollHeight;
    }
}

function escapeHtml(text) {
    const d = document.createElement('div');
    d.textContent = text;
    return d.innerHTML;
}
