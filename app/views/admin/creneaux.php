&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Gestion des créneaux - <?= sanitize($event['titre']) ?></h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Commentaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($creneaux as $c): ?>
                    <tr>
                        <td><?= sanitize($c['type']) ?></td>
                        <td><?= formatDate($c['date_creneau']) ?></td>
                        <td><?= substr($c['heure_debut'],0,5) ?> - <?= substr($c['heure_fin'],0,5) ?></td>
                        <td><?= sanitize($c['commentaire']) ?></td>
                        <td>
                            <form method="POST" action="<?= url('/admin/delete-creneau') ?>" class="inline-form">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <input type="hidden" name="id_creneau" value="<?= $c['id_creneau'] ?>">
                                <input type="hidden" name="id_event_sport" value="<?= $event['id_event_sport'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr ?">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <p class="text-muted">Note : Les formulaires de création/modification complets sont disponibles dans l'ancien système</p>
    <a href="<?= url('/admin/events-sport') ?>" class="btn btn-secondary">Retour aux événements</a>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
