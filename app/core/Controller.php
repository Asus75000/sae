&lt;?php

/**
 * Classe de base pour tous les contrôleurs
 */
class Controller {

    /**
     * Charge une vue avec des données
     * @param string $view Nom de la vue (chemin relatif depuis app/views)
     * @param array $data Données à passer à la vue
     */
    protected function view($view, $data = []) {
        extract($data);
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if(file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Vue introuvable : " . $view);
        }
    }

    /**
     * Charge un modèle
     * @param string $model Nom du modèle
     * @return object Instance du modèle
     */
    protected function model($model) {
        $modelPath = __DIR__ . '/../models/' . $model . '.php';

        if(file_exists($modelPath)) {
            require_once $modelPath;
            return new $model();
        } else {
            die("Modèle introuvable : " . $model);
        }
    }

    /**
     * Redirige vers une URL
     * @param string $url URL de destination
     */
    protected function redirect($url) {
        header("Location: " . $url);
        exit;
    }

    /**
     * Enregistre un message flash
     * @param string $message Message à afficher
     * @param string $type Type de message (success, danger, warning, info)
     */
    protected function flash($message, $type = 'info') {
        $_SESSION['flash'] = ['message' => $message, 'type' => $type];
    }

    /**
     * Vérifie si l'utilisateur est connecté
     * @return bool
     */
    protected function isLogged() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Vérifie si l'utilisateur est admin
     * @return bool
     */
    protected function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
    }

    /**
     * Exige que l'utilisateur soit connecté
     */
    protected function requireLogin() {
        if(!$this->isLogged()) {
            $this->redirect('/');
            exit;
        }
    }

    /**
     * Exige que l'utilisateur soit admin
     */
    protected function requireAdmin() {
        $this->requireLogin();
        if(!$this->isAdmin()) {
            $this->redirect('/membre');
            exit;
        }
    }
}
