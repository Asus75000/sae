# KASTA CROSSFIT - Architecture MVC

Application de gestion pour l'association KASTA CROSSFIT, refactorisée selon une architecture MVC (Model-View-Controller) propre et moderne.

## Architecture du projet

```
/
├── public/                     # Point d'entrée web (DocumentRoot)
│   ├── index.php              # Routeur principal
│   ├── .htaccess              # Règles de réécriture
│   └── assets/
│       ├── css/
│       │   └── style.css      # Feuilles de style CSS
│       └── js/
│           └── script.js      # Scripts JavaScript
│
├── app/                        # Code de l'application
│   ├── models/                # Modèles (accès données)
│   │   ├── Membre.php
│   │   ├── EventSport.php
│   │   ├── EventAsso.php
│   │   ├── Creneau.php
│   │   └── Categorie.php
│   │
│   ├── controllers/           # Contrôleurs (logique métier)
│   │   ├── AuthController.php
│   │   ├── EventController.php
│   │   ├── MembreController.php
│   │   ├── InscriptionController.php
│   │   ├── AdminController.php
│   │   ├── AdminEventController.php
│   │   └── AdminCreneauController.php
│   │
│   ├── views/                 # Vues (affichage HTML)
│   │   ├── layouts/
│   │   │   ├── header.php
│   │   │   └── footer.php
│   │   ├── auth/
│   │   ├── events/
│   │   ├── membre/
│   │   ├── inscription/
│   │   └── admin/
│   │
│   └── core/                  # Classes fondamentales
│       ├── Database.php       # Connexion BDD (Singleton)
│       ├── Router.php         # Routage des URLs
│       ├── Controller.php     # Classe de base des contrôleurs
│       └── helpers.php        # Fonctions utilitaires
│
├── config/
│   └── config.php             # Configuration de l'application
│
├── .htaccess                  # Redirection vers public/
└── README.md                  # Ce fichier
```

## Principes de l'architecture MVC

### Séparation des responsabilités

1. **Modèles (Models)** - `app/models/`
   - Gèrent l'accès aux données
   - Contiennent la logique métier
   - Communiquent avec la base de données
   - **Pas de HTML, ni CSS, ni JavaScript**

2. **Vues (Views)** - `app/views/`
   - Affichent les données
   - Contiennent uniquement du HTML et PHP pour l'affichage
   - **Pas de logique métier**
   - **Pas de CSS inline**
   - **Pas de JavaScript inline**

3. **Contrôleurs (Controllers)** - `app/controllers/`
   - Gèrent les requêtes HTTP
   - Font le lien entre Modèles et Vues
   - Valident les données
   - **Pas de HTML direct**

### Séparation des assets

- **CSS** : Tous les styles sont dans `public/assets/css/style.css`
- **JavaScript** : Tous les scripts sont dans `public/assets/js/script.js`
- **Aucun style inline** dans les fichiers PHP
- **Aucun script inline** dans les fichiers PHP

### Utilisation de data-attributes pour JavaScript

Au lieu d'utiliser des attributs `onclick`, `onsubmit`, etc., nous utilisons des data-attributes :

```html
<!-- ❌ Mauvais (JavaScript inline) -->
<button onclick="window.location='page.php'">Cliquer</button>

<!-- ✅ Bon (data-attribute) -->
<button data-navigate="/page">Cliquer</button>
```

Les gestionnaires d'événements sont centralisés dans `script.js`.

## Routage

Le routage est géré par `app/core/Router.php`. Toutes les routes sont définies dans `public/index.php` :

```php
// Route GET
$router->get('/evenements', 'EventController@index');

// Route POST
$router->post('/login', 'AuthController@doLogin');

// Route avec paramètre
$router->get('/evenements/{id}', 'EventController@show');
```

## Configuration

Modifier `config/config.php` pour adapter :
- Les paramètres de connexion à la base de données
- L'URL du site
- Le fuseau horaire

## Installation

1. Cloner le dépôt
2. Configurer la base de données dans `config/config.php`
3. Pointer le DocumentRoot vers le dossier `public/`
4. S'assurer que mod_rewrite est activé (Apache)

## Structure de la base de données

- `membre` : Utilisateurs de l'application
- `event_sport` : Événements sportifs
- `event_asso` : Événements associatifs
- `cat_event` : Catégories d'événements
- `creneau_event` : Créneaux pour les événements sportifs
- `aide_benevole` : Inscriptions aux créneaux
- `participer` : Participations aux événements associatifs

## Fonctionnalités

### Pour les membres

- Inscription et connexion
- Consultation des événements
- Inscription aux événements sportifs (créneaux bénévoles)
- Inscription aux événements associatifs
- Gestion du profil

### Pour les administrateurs

- Validation des membres
- Gestion des catégories
- Gestion des événements sportifs et associatifs
- Gestion des créneaux
- Statistiques

## Sécurité

- Protection CSRF sur tous les formulaires
- Mots de passe hashés avec `password_hash()`
- Validation des données côté serveur
- Échappement des sorties avec `htmlspecialchars()`
- Sessions sécurisées

## Bonnes pratiques respectées

✅ **Séparation claire MVC**
✅ **Pas de CSS inline**
✅ **Pas de JavaScript inline**
✅ **Routage centralisé**
✅ **Validation des données**
✅ **Protection CSRF**
✅ **Code documenté**
✅ **Structure organisée**

## Auteurs

Projet développé pour l'association KASTA CROSSFIT.

## Licence

Tous droits réservés © 2025 KASTA CROSSFIT