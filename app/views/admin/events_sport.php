&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Gestion des événements sportifs</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Date de clôture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($events as $e): ?>
                    <tr>
                        <td><?= sanitize($e['titre']) ?></td>
                        <td><?= sanitize($e['categorie']) ?></td>
                        <td><?= formatDateTime($e['date_cloture']) ?></td>
                        <td>
                            <a href="<?= url('/admin/creneaux?event=' . $e['id_event_sport']) ?>" class="btn btn-sm btn-primary">Gérer créneaux</a>

                            <form method="POST" action="<?= url('/admin/delete-event-sport') ?>" class="inline-form">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <input type="hidden" name="id_event_sport" value="<?= $e['id_event_sport'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer cet événement ?">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <p class="text-muted">Note : Les formulaires de création/modification complets sont disponibles dans l'ancien système</p>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
