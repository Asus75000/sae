&lt;?php

/**
 * Fonctions utilitaires globales
 */

/**
 * Nettoie les données pour éviter les attaques XSS
 * @param string $data Données à nettoyer
 * @return string Données nettoyées
 */
function sanitize($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Génère un token CSRF
 * @return string Token CSRF
 */
function generateCSRF() {
    if(!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valide un token CSRF
 * @param string $token Token à valider
 * @return bool
 */
function validateCSRF($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Récupère et supprime le message flash
 * @return array|null
 */
function getFlash() {
    if(isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Formate une date au format français
 * @param string $date Date au format SQL
 * @return string Date formatée
 */
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

/**
 * Formate une date et heure au format français
 * @param string $datetime DateTime au format SQL
 * @return string DateTime formatée
 */
function formatDateTime($datetime) {
    return date('d/m/Y à H:i', strtotime($datetime));
}

/**
 * Valide un email
 * @param string $email
 * @return bool
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Valide un mot de passe
 * @param string $password
 * @return bool
 */
function validatePassword($password) {
    return strlen($password) >= 8 &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[0-9]/', $password);
}

/**
 * Valide un numéro de téléphone français
 * @param string $phone
 * @return bool
 */
function validatePhone($phone) {
    if(empty($phone)) return true;
    $phone = str_replace(' ', '', $phone);
    return preg_match('/^0[1-9][0-9]{8}$/', $phone);
}

/**
 * Génère une URL absolue
 * @param string $path Chemin relatif
 * @return string URL absolue
 */
function url($path = '') {
    return SITE_URL . '/' . ltrim($path, '/');
}

/**
 * Génère une URL vers un asset
 * @param string $path Chemin vers l'asset
 * @return string URL de l'asset
 */
function asset($path) {
    return SITE_URL . '/assets/' . ltrim($path, '/');
}
