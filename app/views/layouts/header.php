&lt;!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KASTA CROSSFIT</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <nav>
        <div class="container">
            <a href="<?= url('/') ?>" class="logo">KASTA CROSSFIT</a>
            <div class="nav-links">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="<?= url('/evenements') ?>">Événements</a>
                    <a href="<?= url('/membre') ?>">Mon Espace</a>
                    <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <a href="<?= url('/admin') ?>">Administration</a>
                    <?php endif; ?>
                    <a href="<?= url('/logout') ?>">Déconnexion</a>
                <?php else: ?>
                    <a href="<?= url('/evenements') ?>">Événements</a>
                    <a href="<?= url('/') ?>">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php $flash = getFlash(); if($flash): ?>
        <div class="container">
            <div class="alert alert-<?= $flash['type'] ?>"><?= sanitize($flash['message']) ?></div>
        </div>
    <?php endif; ?>
