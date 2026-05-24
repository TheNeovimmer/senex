<?php $title = 'Gestion des utilisateurs'; ?>
<div class="section-header">
    <div><h2>Utilisateurs</h2><p><?= $usersData['total'] ?> utilisateurs inscrits</p></div>
    <form method="GET" action="/admin/users/search" class="topbar-search" style="width:auto"><i class="fas fa-search"></i><input type="text" name="q" class="search-input" placeholder="Rechercher..." value="<?= htmlspecialchars($searchQuery ?? '') ?>"></form>
</div>

<div class="dashboard-card" data-aos="fade-up">
    <div class="card-body">
        <?php if (empty($usersData['items'])): ?>
            <div class="empty-state"><i class="fas fa-users"></i><h5>Aucun utilisateur trouvé</h5></div>
        <?php else: ?>
            <table class="table-senex">
                <thead><tr><th>Utilisateur</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Inscrit le</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($usersData['items'] as $u): ?>
                        <tr>
                            <td><div class="user-cell"><img src="<?= $u['avatar_url'] ?? 'https://placehold.co/32x32/1E1E2F/F15BB5?text=' . ($u['username'][0] ?? 'U') ?>" alt=""><span><?= htmlspecialchars($u['username']) ?></span></div></td>
                            <td style="color:rgba(255,255,255,0.5)"><?= htmlspecialchars($u['email']) ?></td>
                            <td><span style="color:<?= ($u['role'] ?? 'user') === 'admin' ? '#F44336' : (($u['role'] ?? 'user') === 'streamer' ? '#9B5DE5' : 'rgba(255,255,255,0.5)') ?>"><?= $u['role'] ?? 'user' ?></span></td>
                            <td><?= ($u['is_active'] ?? true) ? '<span style="color:#4CAF50">Actif</span>' : '<span style="color:#F44336">Suspendu</span>' ?></td>
                            <td style="color:rgba(255,255,255,0.4)"><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                            <td><a href="/admin/users/toggle/<?= $u['id'] ?>" class="btn-senex-outline btn-senex-sm" onclick="return confirm('<?= ($u['is_active'] ?? true) ? 'Suspendre' : 'Réactiver' ?> cet utilisateur?')"><?= ($u['is_active'] ?? true) ? 'Suspendre' : 'Réactiver' ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($usersData['lastPage'] > 1): ?>
                <div class="pagination-senex">
                    <?php for ($i = 1; $i <= $usersData['lastPage']; $i++): ?>
                        <a href="/admin/users?page=<?= $i ?>" class="<?= $i === $usersData['page'] ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
