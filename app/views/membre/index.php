&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Bienvenue <?= sanitize($membre['prenom'] . ' ' . $membre['nom']) ?></h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <h3>Mon profil</h3>
                <p><strong>Email :</strong> <?= sanitize($membre['mail']) ?></p>
                <p><strong>Téléphone :</strong> <?= sanitize($membre['telephone']) ?></p>
                <p><strong>Statut :</strong>
                    <?php if($membre['adherent']): ?>
                        <span class="badge badge-success">Adhérent</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">Non adhérent</span>
                    <?php endif; ?>
                </p>
                <a href="<?= url('/membre/edit') ?>" class="btn">Modifier mon profil</a>
            </div>
        </div>
    </div>

    <h2>Mes inscriptions aux événements sportifs</h2>
    <div class="row">
        <?php if(empty($inscriptionsSport)): ?>
            <div class="col-md-12">
                <p>Aucune inscription pour le moment.</p>
            </div>
        <?php else: ?>
            <?php foreach($inscriptionsSport as $event): ?>
                <div class="col-md-4">
                    <div class="card">
                        <h3><?= sanitize($event['titre']) ?></h3>
                        <p><strong>Catégorie :</strong> <?= sanitize($event['categorie']) ?></p>
                        <p><strong>Créneau :</strong> <?= sanitize($event['type_creneau']) ?></p>
                        <p><strong>Date :</strong> <?= formatDate($event['date_creneau']) ?></p>
                        <p><strong>Horaire :</strong> <?= substr($event['heure_debut'],0,5) ?> - <?= substr($event['heure_fin'],0,5) ?></p>
                        <a href="<?= url('/desinscription/sport?id=' . $event['id_event_sport']) ?>" class="btn btn-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir vous désinscrire ?">Se désinscrire</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h2>Mes inscriptions aux événements associatifs</h2>
    <div class="row">
        <?php if(empty($inscriptionsAsso)): ?>
            <div class="col-md-12">
                <p>Aucune inscription pour le moment.</p>
            </div>
        <?php else: ?>
            <?php foreach($inscriptionsAsso as $event): ?>
                <div class="col-md-4">
                    <div class="card">
                        <h3><?= sanitize($event['titre']) ?></h3>
                        <p><strong>Date :</strong> <?= formatDateTime($event['date_event_asso']) ?></p>
                        <p><strong>Tarif :</strong> <?= number_format($event['tarif'], 2, ',', ' ') ?> €</p>
                        <p><strong>Invités :</strong> <?= $event['nb_invites'] ?></p>
                        <p><strong>Paiement :</strong>
                            <?php if($event['paiement_ok']): ?>
                                <span class="badge badge-success">Payé</span>
                            <?php else: ?>
                                <span class="badge badge-warning">En attente</span>
                            <?php endif; ?>
                        </p>
                        <a href="<?= url('/desinscription/asso?id=' . $event['id_event_asso']) ?>" class="btn btn-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir vous désinscrire ?">Se désinscrire</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
