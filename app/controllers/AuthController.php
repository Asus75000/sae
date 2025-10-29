&lt;?php

/**
 * Contrôleur d'authentification
 */
class AuthController extends Controller {

    /**
     * Affiche le formulaire de connexion
     */
    public function login() {
        // Si déjà connecté, rediriger
        if($this->isLogged()) {
            if($this->isAdmin()) {
                $this->redirect('/admin');
            } else {
                $this->redirect('/membre');
            }
            return;
        }

        $this->view('auth/login', [
            'csrf' => generateCSRF()
        ]);
    }

    /**
     * Traite la connexion
     */
    public function doLogin() {
        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/');
            return;
        }

        $membreModel = $this->model('Membre');
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

        $membre = $membreModel->findByEmail($email);

        if($membre && password_verify($mdp, $membre['mdp'])) {
            if($membre['statut'] === 'VALIDE') {
                $_SESSION['user_id'] = $membre['id_membre'];
                $_SESSION['user_name'] = $membre['prenom'] . ' ' . $membre['nom'];
                $_SESSION['is_admin'] = $membre['gestionnaire_o_n_'];

                $this->redirect($membre['gestionnaire_o_n_'] ? '/admin' : '/membre');
            } else {
                $this->view('auth/login', [
                    'error' => "Votre compte n'est pas encore validé",
                    'csrf' => generateCSRF()
                ]);
            }
        } else {
            $this->view('auth/login', [
                'error' => "Email ou mot de passe incorrect",
                'csrf' => generateCSRF()
            ]);
        }
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function register() {
        $this->view('auth/register', [
            'csrf' => generateCSRF()
        ]);
    }

    /**
     * Traite l'inscription
     */
    public function doRegister() {
        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/register');
            return;
        }

        $membreModel = $this->model('Membre');

        $data = [
            'prenom' => trim($_POST['prenom']),
            'nom' => trim($_POST['nom']),
            'mail' => trim($_POST['mail']),
            'mdp' => $_POST['mdp'],
            'telephone' => trim($_POST['telephone'] ?? ''),
            'taille_teeshirt' => $_POST['taille_teeshirt'] ?? '',
            'taille_pull' => $_POST['taille_pull'] ?? ''
        ];

        $validation = $membreModel->validate($data);

        if(!$validation['valid']) {
            $this->view('auth/register', [
                'error' => implode('<br>', $validation['errors']),
                'csrf' => generateCSRF()
            ]);
        } elseif($membreModel->create($data)) {
            $this->flash("Inscription réussie. En attente de validation par l'administrateur.", "success");
            $this->redirect('/');
        } else {
            $this->view('auth/register', [
                'error' => "Erreur lors de l'inscription. L'email existe peut-être déjà.",
                'csrf' => generateCSRF()
            ]);
        }
    }

    /**
     * Déconnexion
     */
    public function logout() {
        session_destroy();
        $this->redirect('/');
    }
}
