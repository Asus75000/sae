&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Inscription à <?= sanitize($event['titre']) ?></h1>

    <div class="card">
        <h3>Sélectionnez vos créneaux</h3>

        <form method="POST" action="<?= url('/inscription/sport') ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
            <input type="hidden" name="id_event_sport" value="<?= $event['id_event_sport'] ?>">

            <?php foreach($creneaux as $c): ?>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="creneaux[]" value="<?= $c['id_creneau'] ?>">
                        <strong><?= strtoupper($c['type']) ?></strong> -
                        <?= formatDate($c['date_creneau']) ?>
                        de <?= substr($c['heure_debut'],0,5) ?> à <?= substr($c['heure_fin'],0,5) ?>
                        <?php if($c['commentaire']): ?>
                            <br><small><?= sanitize($c['commentaire']) ?></small>
                        <?php endif; ?>
                    </label>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-primary">Valider l'inscription</button>
            <a href="<?= url('/evenements?type=sport') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
