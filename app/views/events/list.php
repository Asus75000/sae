&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Événements</h1>

    <div class="tabs">
        <button class="tab <?= $type === 'sport' ? 'active' : '' ?>" data-navigate="<?= url('/evenements?type=sport') ?>">Sportifs</button>
        <button class="tab <?= $type === 'asso' ? 'active' : '' ?>" data-navigate="<?= url('/evenements?type=asso') ?>">Associatifs</button>
    </div>

    <div class="row">
        <?php foreach($events as $e): ?>
            <div class="col-md-4">
                <div class="card">
                    <h3><?= sanitize($e['titre']) ?></h3>
                    <p><?= sanitize(substr($e['descriptif'], 0, 100)) ?>...</p>

                    <p><small>Clôture : <?= formatDateTime($e['date_cloture']) ?></small></p>

                    <a href="<?= url('/evenements/' . $e[$type === 'sport' ? 'id_event_sport' : 'id_event_asso'] . '?type=' . $type) ?>" class="btn">Voir détails</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
