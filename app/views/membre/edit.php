&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Modifier mon profil</h1>

    <div class="card">
        <form method="POST" action="<?= url('/membre/update') ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">

            <label>Prénom *</label>
            <input type="text" name="prenom" value="<?= sanitize($membre['prenom']) ?>" required>

            <label>Nom *</label>
            <input type="text" name="nom" value="<?= sanitize($membre['nom']) ?>" required>

            <label>Email (non modifiable)</label>
            <input type="email" value="<?= sanitize($membre['mail']) ?>" disabled>

            <label>Téléphone</label>
            <input type="tel" name="telephone" value="<?= sanitize($membre['telephone']) ?>">

            <label>Taille T-shirt</label>
            <select name="taille_teeshirt">
                <option value="">-- Sélectionner --</option>
                <option <?= $membre['taille_teeshirt'] === 'XS' ? 'selected' : '' ?>>XS</option>
                <option <?= $membre['taille_teeshirt'] === 'S' ? 'selected' : '' ?>>S</option>
                <option <?= $membre['taille_teeshirt'] === 'M' ? 'selected' : '' ?>>M</option>
                <option <?= $membre['taille_teeshirt'] === 'L' ? 'selected' : '' ?>>L</option>
                <option <?= $membre['taille_teeshirt'] === 'XL' ? 'selected' : '' ?>>XL</option>
                <option <?= $membre['taille_teeshirt'] === 'XXL' ? 'selected' : '' ?>>XXL</option>
            </select>

            <label>Taille Pull</label>
            <select name="taille_pull">
                <option value="">-- Sélectionner --</option>
                <option <?= $membre['taille_pull'] === 'XS' ? 'selected' : '' ?>>XS</option>
                <option <?= $membre['taille_pull'] === 'S' ? 'selected' : '' ?>>S</option>
                <option <?= $membre['taille_pull'] === 'M' ? 'selected' : '' ?>>M</option>
                <option <?= $membre['taille_pull'] === 'L' ? 'selected' : '' ?>>L</option>
                <option <?= $membre['taille_pull'] === 'XL' ? 'selected' : '' ?>>XL</option>
                <option <?= $membre['taille_pull'] === 'XXL' ? 'selected' : '' ?>>XXL</option>
            </select>

            <hr>

            <h3>Changer le mot de passe</h3>
            <label>Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="new_mdp" placeholder="••••••••" minlength="8">

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="<?= url('/membre') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
