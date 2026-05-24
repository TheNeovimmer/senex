<?php $title = 'Paramètres IA'; ?>
<div class="section-header">
    <div><h2>Intelligence Artificielle</h2><p>Gérez les suggestions et fonctionnalités AI</p></div>
    <button class="btn-senex" data-bs-toggle="modal" data-bs-target="#aiSuggestionModal"><i class="fas fa-robot"></i> Générer suggestion</button>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header"><h5>Suggestions AI</h5></div>
            <div class="card-body">
                <?php if (empty($suggestions)): ?>
                    <div class="empty-state"><i class="fas fa-robot"></i><h5>Aucune suggestion AI</h5><p style="color:rgba(255,255,255,0.4);font-size:.85rem">Générez des suggestions pour les défis, highlights et recommandations.</p></div>
                <?php else: ?>
                    <table class="table-senex">
                        <thead><tr><th>Type</th><th>Contenu</th><th>Statut</th><th>Date</th></tr></thead>
                        <tbody>
                            <?php foreach ($suggestions as $s): ?>
                                <tr>
                                    <td><span class="badge" style="background:<?= $s['type'] === 'challenge' ? '#9B5DE5' : ($s['type'] === 'highlight' ? '#FF9800' : ($s['type'] === 'recommendation' ? '#00BCD4' : '#4CAF50')) ?>"><?= $s['type'] ?></span></td>
                                    <td style="color:rgba(255,255,255,0.6);max-width:300px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars(\Core\Helpers::truncate($s['content'], 100)) ?></td>
                                    <td><span style="color:<?= $s['status'] === 'pending' ? '#FF9800' : ($s['status'] === 'approved' ? '#4CAF50' : '#F44336') ?>"><?= $s['status'] ?></span></td>
                                    <td style="color:rgba(255,255,255,0.4)"><?= date('d/m/Y H:i', strtotime($s['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-card" data-aos="fade-up" data-aos-delay="50">
            <div class="card-header"><h5>Configuration</h5></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Clé API OpenAI</label>
                    <input type="password" class="form-control" value="<?= $_ENV['OPENAI_API_KEY'] ? '••••••••' . substr($_ENV['OPENAI_API_KEY'], -4) : 'Non configurée' ?>" readonly>
                    <div class="form-text">Configurez dans le fichier .env: OPENAI_API_KEY=votre_clé</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fonctionnalités</label>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" checked style="cursor:pointer;background-color:#F15BB5;border-color:#F15BB5">
                        <label class="form-check-label" style="color:rgba(255,255,255,0.7);font-size:.85rem">Génération de défis</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" checked style="cursor:pointer;background-color:#F15BB5;border-color:#F15BB5">
                        <label class="form-check-label" style="color:rgba(255,255,255,0.7);font-size:.85rem">Highlights automatiques</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" checked style="cursor:pointer;background-color:#F15BB5;border-color:#F15BB5">
                        <label class="form-check-label" style="color:rgba(255,255,255,0.7);font-size:.85rem">Recommandations</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked style="cursor:pointer;background-color:#F15BB5;border-color:#F15BB5">
                        <label class="form-check-label" style="color:rgba(255,255,255,0.7);font-size:.85rem">Modération automatique</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-senex" id="aiSuggestionModal">
    <div class="modal-dialog">
        <form method="POST" action="/admin/ai/generate" class="modal-content form-senex">
            <div class="modal-header"><h5 class="modal-title">Générer suggestion AI</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <p style="color:rgba(255,255,255,0.5);font-size:.85rem">L'IA analysera les données de la plateforme pour générer des suggestions pertinentes.</p>
                <button type="submit" class="btn-senex w-100"><i class="fas fa-robot me-2"></i> Générer avec l'IA</button>
            </div>
        </form>
    </div>
</div>
