&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Gestion des membres</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Adhérent</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($membres as $m): ?>
                    <tr>
                        <td><?= sanitize($m['prenom'] . ' ' . $m['nom']) ?></td>
                        <td><?= sanitize($m['mail']) ?></td>
                        <td>
                            <?php if($m['statut'] === 'VALIDE'): ?>
                                <span class="badge badge-success">Validé</span>
                            <?php else: ?>
                                <span class="badge badge-warning">En attente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($m['adherent']): ?>
                                <span class="badge badge-success">Oui</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Non</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($m['statut'] !== 'VALIDE'): ?>
                                <form method="POST" action="<?= url('/admin/valider-membre') ?>" class="inline-form">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                    <input type="hidden" name="id_membre" value="<?= $m['id_membre'] ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Valider</button>
                                </form>
                            <?php endif; ?>

                            <form method="POST" action="<?= url('/admin/toggle-adherent') ?>" class="inline-form">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <input type="hidden" name="id_membre" value="<?= $m['id_membre'] ?>">
                                <input type="hidden" name="adherent" value="<?= $m['adherent'] ? 0 : 1 ?>">
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <?= $m['adherent'] ? 'Retirer adhésion' : 'Faire adhérent' ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
