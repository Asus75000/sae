# Guide d'installation - KASTA CROSSFIT

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Apache avec mod_rewrite activé
- Serveur web local (XAMPP, WAMP, MAMP, etc.)

## Étapes d'installation

### 1. Cloner le projet

```bash
git clone https://github.com/Asus75000/sae.git
cd sae
```

### 2. Configuration de la base de données

1. Créer une base de données MySQL nommée `kasta`
2. Importer le schéma de la base de données (si vous avez un fichier SQL)
3. Configurer les paramètres de connexion dans `config/config.php`

```php
// config/config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'kasta');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 3. Configuration de l'URL du site

Modifier `SITE_URL` dans `config/config.php` selon votre configuration :

```php
// Exemples de configuration
define('SITE_URL', 'http://localhost/kasta-crossfit');  // Si dans un sous-dossier
// OU
define('SITE_URL', 'http://localhost');  // Si à la racine
```

### 4. Configuration Apache

**Option A : Configuration simple (recommandée pour développement)**

Placez le projet dans votre dossier www/htdocs et accédez via :
```
http://localhost/kasta-crossfit/
```

Le `.htaccess` racine redirigera automatiquement vers le dossier `public/`.

**Option B : Configuration optimale (recommandée pour production)**

Configurez Apache pour pointer directement vers le dossier `public/` :

```apache
<VirtualHost *:80>
    ServerName kasta-crossfit.local
    DocumentRoot "/chemin/vers/sae/public"

    <Directory "/chemin/vers/sae/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Ajoutez dans votre fichier hosts :
```
127.0.0.1   kasta-crossfit.local
```

Puis modifiez `SITE_URL` :
```php
define('SITE_URL', 'http://kasta-crossfit.local');
```

### 5. Vérifier mod_rewrite

Assurez-vous que `mod_rewrite` est activé dans Apache :

**Sur Linux :**
```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

**Sur Windows (XAMPP/WAMP) :**
Vérifiez dans httpd.conf que la ligne suivante n'est pas commentée :
```
LoadModule rewrite_module modules/mod_rewrite.so
```

### 6. Permissions (Linux/Mac uniquement)

```bash
chmod -R 755 /chemin/vers/sae
chmod -R 777 /chemin/vers/sae/public/assets
```

## Test de l'installation

1. Accédez à l'URL configurée dans votre navigateur
2. Vous devriez voir la page de connexion
3. Créez un compte ou connectez-vous avec un compte existant

## Résolution des problèmes

### Erreur "404 - Page non trouvée"

- Vérifiez que mod_rewrite est activé
- Vérifiez que les fichiers .htaccess sont présents
- Vérifiez la valeur de SITE_URL

### Les styles CSS ne se chargent pas

- Vérifiez que les assets sont dans `public/assets/css/` et `public/assets/js/`
- Vérifiez la valeur de SITE_URL
- Ouvrez la console du navigateur pour voir les erreurs 404

### Erreur de connexion à la base de données

- Vérifiez les paramètres dans `config/config.php`
- Assurez-vous que MySQL est démarré
- Vérifiez que la base de données `kasta` existe

### Les sessions ne fonctionnent pas

- Vérifiez que PHP a les droits d'écriture dans le dossier de sessions
- Sur Linux : `sudo chmod 777 /var/lib/php/sessions`

## Structure des URLs

Avec la configuration par défaut :

- Page d'accueil : `http://localhost/kasta-crossfit/`
- Événements : `http://localhost/kasta-crossfit/evenements`
- Espace membre : `http://localhost/kasta-crossfit/membre`
- Administration : `http://localhost/kasta-crossfit/admin`

## Premier compte administrateur

Pour créer votre premier compte administrateur :

1. Inscrivez-vous normalement via l'interface
2. Dans la base de données, modifiez manuellement votre compte :

```sql
UPDATE membre
SET statut = 'VALIDE', gestionnaire_o_n_ = 1, adherent = 1
WHERE mail = 'votre@email.com';
```

## Support

Pour toute question ou problème, consultez le README.md ou créez une issue sur GitHub.
