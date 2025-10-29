&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Gestion des événements associatifs</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date événement</th>
                    <th>Tarif</th>
                    <th>Privé</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($events as $e): ?>
                    <tr>
                        <td><?= sanitize($e['titre']) ?></td>
                        <td><?= formatDateTime($e['date_event_asso']) ?></td>
                        <td><?= number_format($e['tarif'], 2, ',', ' ') ?> €</td>
                        <td>
                            <?php if($e['prive']): ?>
                                <span class="badge badge-warning">Oui</span>
                            <?php else: ?>
                                <span class="badge badge-success">Non</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" action="<?= url('/admin/delete-event-asso') ?>" class="inline-form">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <input type="hidden" name="id_event_asso" value="<?= $e['id_event_asso'] ?>">
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
