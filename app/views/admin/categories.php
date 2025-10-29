&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Gestion des catégories</h1>

    <div class="card">
        <h3>Ajouter une catégorie</h3>
        <form method="POST" action="<?= url('/admin/create-categorie') ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
            <label>Libellé</label>
            <input type="text" name="libelle" required>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $cat): ?>
                    <tr>
                        <td><?= sanitize($cat['libelle']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-secondary" data-toggle-edit="cat-<?= $cat['id_cat_event'] ?>">Modifier</button>

                            <form method="POST" action="<?= url('/admin/delete-categorie') ?>" class="inline-form">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <input type="hidden" name="id_cat_event" value="<?= $cat['id_cat_event'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr ?">Supprimer</button>
                            </form>

                            <div class="edit-form" id="edit-cat-<?= $cat['id_cat_event'] ?>" data-hidden>
                                <form method="POST" action="<?= url('/admin/update-categorie') ?>">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                    <input type="hidden" name="id_cat_event" value="<?= $cat['id_cat_event'] ?>">
                                    <input type="text" name="libelle" value="<?= sanitize($cat['libelle']) ?>" required>
                                    <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
