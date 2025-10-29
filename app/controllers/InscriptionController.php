&lt;?php

/**
 * Contrôleur des inscriptions
 */
class InscriptionController extends Controller {

    /**
     * Affiche le formulaire d'inscription à un événement
     */
    public function show() {
        $this->requireLogin();

        $type = $_GET['type'] ?? 'sport';
        $id = $_GET['id'] ?? null;

        if(!$id) {
            $this->redirect('/evenements?type=' . $type);
            return;
        }

        if($type === 'sport') {
            $eventModel = $this->model('EventSport');
            $creneauModel = $this->model('Creneau');

            $event = $eventModel->find($id);
            $creneaux = $creneauModel->getByEvent($id);

            $this->view('inscription/sport', [
                'event' => $event,
                'creneaux' => $creneaux,
                'csrf' => generateCSRF()
            ]);
        } else {
            $eventModel = $this->model('EventAsso');
            $event = $eventModel->find($id);

            $this->view('inscription/asso', [
                'event' => $event,
                'csrf' => generateCSRF()
            ]);
        }
    }

    /**
     * Traite l'inscription à un événement sportif
     */
    public function registerSport() {
        $this->requireLogin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/evenements?type=sport');
            return;
        }

        $id_event = $_POST['id_event_sport'];
        $creneaux = $_POST['creneaux'] ?? [];

        if(empty($creneaux)) {
            $this->flash("Veuillez sélectionner au moins un créneau", "danger");
            $this->redirect('/inscription?type=sport&id=' . $id_event);
            return;
        }

        $creneauModel = $this->model('Creneau');

        foreach($creneaux as $id_creneau) {
            $creneauModel->registerUser($id_creneau, $_SESSION['user_id']);
        }

        $this->flash("Inscription réussie !", "success");
        $this->redirect('/membre');
    }

    /**
     * Traite l'inscription à un événement associatif
     */
    public function registerAsso() {
        $this->requireLogin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/evenements?type=asso');
            return;
        }

        $id_event = $_POST['id_event_asso'];
        $nb_invites = intval($_POST['nb_invites'] ?? 0);

        $eventModel = $this->model('EventAsso');

        if($eventModel->registerUser($_SESSION['user_id'], $id_event, $nb_invites)) {
            $this->flash("Inscription réussie !", "success");
        } else {
            $this->flash("Erreur lors de l'inscription", "danger");
        }

        $this->redirect('/membre');
    }

    /**
     * Traite la désinscription d'un événement sportif
     */
    public function unregisterSport() {
        $this->requireLogin();

        $id_event = $_GET['id'] ?? null;

        if($id_event) {
            $eventModel = $this->model('EventSport');
            $eventModel->unregisterUser($id_event, $_SESSION['user_id']);
            $this->flash("Désinscription effectuée", "success");
        }

        $this->redirect('/membre');
    }

    /**
     * Traite la désinscription d'un événement associatif
     */
    public function unregisterAsso() {
        $this->requireLogin();

        $id_event = $_GET['id'] ?? null;

        if($id_event) {
            $eventModel = $this->model('EventAsso');
            $eventModel->unregisterUser($_SESSION['user_id'], $id_event);
            $this->flash("Désinscription effectuée", "success");
        }

        $this->redirect('/membre');
    }
}
