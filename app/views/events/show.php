&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1><?= sanitize($event['titre']) ?></h1>
    <div class="card">
        <p><?= nl2br(sanitize($event['descriptif'])) ?></p>

        <p><strong>Lieu :</strong> <?= sanitize($event['lieu_texte']) ?>
            <?php if($event['lieu_maps']): ?>
                <a href="<?= sanitize($event['lieu_maps']) ?>" target="_blank">Voir sur la carte</a>
            <?php endif; ?>
        </p>

        <p><strong>Inscriptions jusqu'au :</strong> <?= formatDateTime($event['date_cloture']) ?></p>

        <?php if($type === 'sport' && isset($creneaux)): ?>
            <h3>Créneaux disponibles</h3>
            <?php foreach($creneaux as $c): ?>
                <p>
                    <strong><?= strtoupper($c['type']) ?></strong> - <?= formatDate($c['date_creneau']) ?>
                    de <?= substr($c['heure_debut'],0,5) ?> à <?= substr($c['heure_fin'],0,5) ?>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if($type === 'asso'): ?>
            <div class="tarif-box tarif-box-payant">
                <p class="tarif-amount">
                    <strong>Tarif :</strong>
                    <span class="tarif-payant-text"><?= number_format($event['tarif'], 2, ',', ' ') ?> €</span>
                    <br>
                    <small class="color-gray">Paiement sur place le jour de l'événement</small>
                </p>
            </div>

            <p><strong>Date événement :</strong> <?= formatDateTime($event['date_event_asso']) ?></p>
        <?php endif; ?>

        <?php if(isLogged() && strtotime($event['date_cloture']) > time()): ?>
            <a href="<?= url('/inscription?type=' . $type . '&id=' . $event[$type === 'sport' ? 'id_event_sport' : 'id_event_asso']) ?>" class="btn">S'inscrire</a>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
