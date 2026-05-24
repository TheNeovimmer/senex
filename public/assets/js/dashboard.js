document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.dashboard-sidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 992 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    }
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(el) { return new bootstrap.Tooltip(el); });
    const globalSearch = document.getElementById('globalSearch');
    if (globalSearch) {
        let searchTimeout;
        globalSearch.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            searchTimeout = setTimeout(function() {
                if (query.length >= 2) {
                    window.location.href = '/dashboard/search?q=' + encodeURIComponent(query);
                }
            }, 500);
        });
    }
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
            }
        });
    });
    const autoDismissAlerts = document.querySelectorAll('.alert-dismissible');
    autoDismissAlerts.forEach(function(alert) {
        setTimeout(function() {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showToast('Copié dans le presse-papier', 'success');
    });
}

function showToast(message, type) {
    const toastContainer = document.getElementById('toastContainer') || (function() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.cssText = 'position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:8px;';
        document.body.appendChild(container);
        return container;
    })();
    const toast = document.createElement('div');
    toast.style.cssText = 'background:#1a1a3e;border:1px solid rgba(241,91,181,0.2);border-radius:12px;padding:12px 20px;color:#fff;font-size:.88rem;display:flex;align-items:center;gap:10px;animation:slideIn .3s ease;box-shadow:0 8px 30px rgba(0,0,0,0.3);';
    const icon = document.createElement('i');
    icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
    icon.style.color = type === 'success' ? '#4CAF50' : '#F44336';
    toast.appendChild(icon);
    toast.appendChild(document.createTextNode(message));
    toastContainer.appendChild(toast);
    setTimeout(function() {
        toast.style.animation = 'slideOut .3s ease';
        setTimeout(function() { toast.remove(); }, 300);
    }, 3000);
}

const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
`;
document.head.appendChild(style);
