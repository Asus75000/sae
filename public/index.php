&lt;?php

/**
 * Point d'entrée unique de l'application
 * Architecture MVC - Kasta CrossFit
 */

// Démarrer la session
session_start();

// Chargement de la configuration
require_once __DIR__ . '/../config/config.php';

// Chargement des fichiers core
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/helpers.php';

// Création du routeur
$router = new Router();

// ================================
// ROUTES PUBLIQUES
// ================================

// Authentification
$router->get('/', 'AuthController@login');
$router->post('/login', 'AuthController@doLogin');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@doRegister');
$router->get('/logout', 'AuthController@logout');

// Événements publics
$router->get('/evenements', 'EventController@index');
$router->get('/evenements/{id}', 'EventController@show');

// ================================
// ROUTES MEMBRES
// ================================

// Espace membre
$router->get('/membre', 'MembreController@index');
$router->get('/membre/edit', 'MembreController@edit');
$router->post('/membre/update', 'MembreController@update');

// Inscriptions
$router->get('/inscription', 'InscriptionController@show');
$router->post('/inscription/sport', 'InscriptionController@registerSport');
$router->post('/inscription/asso', 'InscriptionController@registerAsso');
$router->get('/desinscription/sport', 'InscriptionController@unregisterSport');
$router->get('/desinscription/asso', 'InscriptionController@unregisterAsso');

// ================================
// ROUTES ADMIN
// ================================

// Dashboard admin
$router->get('/admin', 'AdminController@index');

// Gestion des membres
$router->get('/admin/membres', 'AdminController@membres');
$router->post('/admin/valider-membre', 'AdminController@validerMembre');
$router->post('/admin/toggle-adherent', 'AdminController@toggleAdherent');

// Gestion des catégories
$router->get('/admin/categories', 'AdminController@categories');
$router->post('/admin/create-categorie', 'AdminController@createCategorie');
$router->post('/admin/update-categorie', 'AdminController@updateCategorie');
$router->post('/admin/delete-categorie', 'AdminController@deleteCategorie');

// Gestion des événements sportifs
$router->get('/admin/events-sport', 'AdminEventController@eventsSport');
$router->post('/admin/create-event-sport', 'AdminEventController@createEventSport');
$router->post('/admin/update-event-sport', 'AdminEventController@updateEventSport');
$router->post('/admin/delete-event-sport', 'AdminEventController@deleteEventSport');

// Gestion des événements associatifs
$router->get('/admin/events-asso', 'AdminEventController@eventsAsso');
$router->post('/admin/create-event-asso', 'AdminEventController@createEventAsso');
$router->post('/admin/update-event-asso', 'AdminEventController@updateEventAsso');
$router->post('/admin/delete-event-asso', 'AdminEventController@deleteEventAsso');

// Gestion des créneaux
$router->get('/admin/creneaux', 'AdminCreneauController@index');
$router->post('/admin/create-creneau', 'AdminCreneauController@create');
$router->post('/admin/update-creneau', 'AdminCreneauController@update');
$router->post('/admin/delete-creneau', 'AdminCreneauController@delete');

// Dispatcher la requête
$router->dispatch();
