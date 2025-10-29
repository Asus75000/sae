&lt;?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <div class="login-container">
        <div class="card login-card">
            <h1>Connexion</h1>
            <p class="subtitle">Bienvenue sur KASTA CROSSFIT</p>

            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= sanitize($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= url('/login') ?>">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">

                <label>Email</label>
                <input type="email" name="email" placeholder="votre@email.fr" required autofocus>

                <label>Mot de passe</label>
                <input type="password" name="mdp" placeholder="••••••••" required>

                <button type="submit" name="login" class="btn btn-primary btn-block">Se connecter</button>
            </form>

            <div class="login-footer">
                <p>Pas encore de compte ?</p>
                <a href="<?= url('/register') ?>" class="btn btn-secondary btn-block">Créer un compte</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
