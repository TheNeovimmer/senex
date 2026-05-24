<header class="dashboard-topbar">
    <div class="topbar-left">
        <button class="sidebar-toggle d-lg-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-search">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" placeholder="Rechercher..." id="globalSearch">
        </div>
    </div>
    <div class="topbar-right">
        <div class="topbar-notifications dropdown">
            <button class="btn btn-icon" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                <?php if ($unreadCount > 0): ?>
                    <span class="notification-dot"><?= min($unreadCount, 99) ?></span>
                <?php endif; ?>
            </button>
            <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                <div class="dropdown-header">
                    <h6>Notifications</h6>
                    <?php if ($unreadCount > 0): ?>
                        <a href="/dashboard/notifications/read-all" class="btn btn-sm btn-link">Tout lu</a>
                    <?php endif; ?>
                </div>
                <?php if (empty($notifications)): ?>
                    <div class="dropdown-item text-center text-muted">Aucune notification</div>
                <?php else: ?>
                    <?php foreach (array_slice($notifications, 0, 5) as $notif): ?>
                        <a class="dropdown-item <?= !$notif['is_read'] ? 'unread' : '' ?>" href="<?= $notif['link'] ?? '#' ?>">
                            <div class="notif-icon"><i class="fas fa-<?= $notif['type'] === 'suspension' ? 'ban' : ($notif['type'] === 'welcome' ? 'hand-wave' : 'bell') ?>"></i></div>
                            <div class="notif-content">
                                <strong><?= htmlspecialchars($notif['title']) ?></strong>
                                <p><?= htmlspecialchars($notif['message'] ?? '') ?></p>
                                <small><?= \Core\Helpers::timeAgo($notif['created_at']) ?></small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="topbar-user dropdown">
            <button class="btn dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                <img src="<?= $user['avatar_url'] ?? 'https://placehold.co/40x40/1E1E2F/F15BB5?text=' . ($user['username'][0] ?? 'U') ?>" alt="Avatar" class="user-avatar">
                <span class="user-name d-none d-md-inline"><?= htmlspecialchars($user['username'] ?? 'User') ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="/dashboard/profile"><i class="fas fa-user me-2"></i>Profil</a></li>
                <li><a class="dropdown-item" href="/dashboard/settings"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
            </ul>
        </div>
    </div>
</header>
