<aside class="dashboard-sidebar">
    <div class="sidebar-brand">
        <a href="/dashboard">
            <span class="sidebar-logo">SENEX</span>
            <span class="sidebar-tagline">Dashboard</span>
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <?php if ($user['role'] === 'user' || $user['role'] === 'streamer' || $user['role'] === 'admin'): ?>
            <li class="nav-item">
                <a href="/dashboard" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/dashboard') && !str_contains($_SERVER['REQUEST_URI'], '/dashboard/') ? 'active' : '' ?>">
                    <i class="fas fa-th-large"></i><span>Vue d'ensemble</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($user['role'] === 'user' || $user['role'] === 'streamer' || $user['role'] === 'admin'): ?>
            <li class="nav-section-label">Explorer</li>
            <li class="nav-item">
                <a href="/dashboard/challenges" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/dashboard/challenges') ? 'active' : '' ?>">
                    <i class="fas fa-tasks"></i><span>Défis</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/profile" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/dashboard/profile') ? 'active' : '' ?>">
                    <i class="fas fa-user"></i><span>Profil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/settings" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/dashboard/settings') ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i><span>Paramètres</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($user['role'] === 'streamer' || $user['role'] === 'admin'): ?>
            <li class="nav-section-label">Streaming</li>
            <li class="nav-item">
                <a href="/streamer" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/streamer') && !str_contains($_SERVER['REQUEST_URI'], '/streamer/') ? 'active' : '' ?>">
                    <i class="fas fa-broadcast-tower"></i><span>Studio</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/streamer/streams" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/streamer/streams') ? 'active' : '' ?>">
                    <i class="fas fa-video"></i><span>Mes Streams</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/streamer/live" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/streamer/live') ? 'active' : '' ?>">
                    <i class="fas fa-circle text-danger"></i><span>Go Live</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/streamer/challenges" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/streamer/challenges') ? 'active' : '' ?>">
                    <i class="fas fa-trophy"></i><span>Défis</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/streamer/replays" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/streamer/replays') ? 'active' : '' ?>">
                    <i class="fas fa-history"></i><span>Replays</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/streamer/highlights" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/streamer/highlights') ? 'active' : '' ?>">
                    <i class="fas fa-star"></i><span>Highlights</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($user['role'] === 'admin'): ?>
            <li class="nav-section-label">Administration</li>
            <li class="nav-item">
                <a href="/admin/users" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/users') ? 'active' : '' ?>">
                    <i class="fas fa-users"></i><span>Utilisateurs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/streams" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/streams') ? 'active' : '' ?>">
                    <i class="fas fa-video"></i><span>Streams</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/challenges" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/challenges') ? 'active' : '' ?>">
                    <i class="fas fa-tasks"></i><span>Défis</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/reports" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/reports') ? 'active' : '' ?>">
                    <i class="fas fa-flag"></i><span>Signalements</span>
                    <?php if ($pendingReports > 0): ?>
                        <span class="nav-badge"><?= $pendingReports ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/categories" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/categories') ? 'active' : '' ?>">
                    <i class="fas fa-tags"></i><span>Catégories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/badges" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/badges') ? 'active' : '' ?>">
                    <i class="fas fa-certificate"></i><span>Badges</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/ai" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/ai') ? 'active' : '' ?>">
                    <i class="fas fa-robot"></i><span>IA</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="/home" class="nav-link"><i class="fas fa-globe"></i><span>Site public</span></a>
        <a href="/logout" class="nav-link"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a>
    </div>
</aside>
