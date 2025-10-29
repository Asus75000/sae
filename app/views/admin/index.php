&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Tableau de bord administrateur</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card">
                <h3><?= $statsMembers['total'] ?></h3>
                <p>Membres total</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <h3><?= $statsMembers['en_attente'] ?></h3>
                <p>En attente de validation</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <h3><?= $statsEvents['sport'] ?></h3>
                <p>Événements sportifs</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <h3><?= $statsEvents['asso'] ?></h3>
                <p>Événements associatifs</p>
            </div>
        </div>
    </div>

    <div class="admin-menu">
        <a href="<?= url('/admin/membres') ?>" class="btn btn-primary">Gérer les membres</a>
        <a href="<?= url('/admin/categories') ?>" class="btn btn-primary">Gérer les catégories</a>
        <a href="<?= url('/admin/events-sport') ?>" class="btn btn-primary">Gérer les événements sportifs</a>
        <a href="<?= url('/admin/events-asso') ?>" class="btn btn-primary">Gérer les événements associatifs</a>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
