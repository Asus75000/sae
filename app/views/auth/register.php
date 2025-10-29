&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <div class="login-container">
        <div class="card login-card">
            <h1>Créer un compte</h1>
            <p class="subtitle">Rejoignez KASTA CROSSFIT</p>

            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= url('/register') ?>">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">

                <label>Prénom *</label>
                <input type="text" name="prenom" placeholder="Prénom" required>

                <label>Nom *</label>
                <input type="text" name="nom" placeholder="Nom" required>

                <label>Email *</label>
                <input type="email" name="mail" placeholder="votre@email.fr" required>

                <label>Mot de passe * (minimum 8 caractères)</label>
                <input type="password" name="mdp" placeholder="••••••••" required minlength="8">

                <label>Téléphone</label>
                <input type="tel" name="telephone" placeholder="0612345678">

                <label>Taille T-shirt</label>
                <select name="taille_teeshirt">
                    <option value="">-- Sélectionner --</option>
                    <option>XS</option>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                    <option>XXL</option>
                </select>

                <label>Taille Pull</label>
                <select name="taille_pull">
                    <option value="">-- Sélectionner --</option>
                    <option>XS</option>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                    <option>XXL</option>
                </select>

                <button type="submit" name="register" class="btn btn-primary btn-block">S'inscrire</button>
            </form>

            <div class="login-footer">
                <p>Vous avez déjà un compte ?</p>
                <a href="<?= url('/') ?>" class="btn btn-secondary btn-block">Se connecter</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
