&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Inscription à <?= sanitize($event['titre']) ?></h1>

    <div class="card">
        <p><strong>Date :</strong> <?= formatDateTime($event['date_event_asso']) ?></p>
        <p><strong>Lieu :</strong> <?= sanitize($event['lieu_texte']) ?></p>
        <p><strong>Tarif :</strong> <?= number_format($event['tarif'], 2, ',', ' ') ?> €</p>

        <form method="POST" action="<?= url('/inscription/asso') ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
            <input type="hidden" name="id_event_asso" value="<?= $event['id_event_asso'] ?>">

            <label>Nombre d'invités</label>
            <input type="number" name="nb_invites" min="0" max="10" value="0">
            <small>Le tarif s'applique à chaque invité</small>

            <button type="submit" class="btn btn-primary">Valider l'inscription</button>
            <a href="<?= url('/evenements?type=asso') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
