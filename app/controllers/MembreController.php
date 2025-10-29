&lt;?php

/**
 * Contrôleur de l'espace membre
 */
class MembreController extends Controller {

    /**
     * Affiche l'espace membre
     */
    public function index() {
        $this->requireLogin();

        $membreModel = $this->model('Membre');
        $membre = $membreModel->find($_SESSION['user_id']);

        $inscriptionsSport = $membreModel->getInscriptionsEventsSport($_SESSION['user_id']);
        $inscriptionsAsso = $membreModel->getInscriptionsEventsAsso($_SESSION['user_id']);

        $this->view('membre/index', [
            'membre' => $membre,
            'inscriptionsSport' => $inscriptionsSport,
            'inscriptionsAsso' => $inscriptionsAsso
        ]);
    }

    /**
     * Affiche le formulaire d'édition du profil
     */
    public function edit() {
        $this->requireLogin();

        $membreModel = $this->model('Membre');
        $membre = $membreModel->find($_SESSION['user_id']);

        $this->view('membre/edit', [
            'membre' => $membre,
            'csrf' => generateCSRF()
        ]);
    }

    /**
     * Traite la mise à jour du profil
     */
    public function update() {
        $this->requireLogin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/membre/edit');
            return;
        }

        $membreModel = $this->model('Membre');

        $data = [
            'prenom' => trim($_POST['prenom']),
            'nom' => trim($_POST['nom']),
            'telephone' => trim($_POST['telephone'] ?? ''),
            'taille_teeshirt' => $_POST['taille_teeshirt'] ?? '',
            'taille_pull' => $_POST['taille_pull'] ?? ''
        ];

        // Si changement de mot de passe
        if(!empty($_POST['new_mdp'])) {
            if(!validatePassword($_POST['new_mdp'])) {
                $this->flash("Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.", "danger");
                $this->redirect('/membre/edit');
                return;
            }
            $data['mdp'] = password_hash($_POST['new_mdp'], PASSWORD_DEFAULT);
        }

        if($membreModel->update($_SESSION['user_id'], $data)) {
            $this->flash("Profil mis à jour avec succès", "success");
        } else {
            $this->flash("Erreur lors de la mise à jour du profil", "danger");
        }

        $this->redirect('/membre');
    }
}
