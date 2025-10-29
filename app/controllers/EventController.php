&lt;?php

/**
 * Contrôleur des événements
 */
class EventController extends Controller {

    /**
     * Affiche la liste des événements
     */
    public function index() {
        $type = $_GET['type'] ?? 'sport';

        if($type === 'sport') {
            $eventModel = $this->model('EventSport');
            $events = $eventModel->getAll();
        } else {
            $eventModel = $this->model('EventAsso');
            $membreModel = $this->model('Membre');

            $is_adherent = false;
            if($this->isLogged()) {
                $membre = $membreModel->find($_SESSION['user_id']);
                $is_adherent = $membre['adherent'];
            }

            $events = $eventModel->getAll($this->isAdmin(), $_SESSION['user_id'] ?? null, $is_adherent);
        }

        $this->view('events/list', [
            'type' => $type,
            'events' => $events
        ]);
    }

    /**
     * Affiche le détail d'un événement
     */
    public function show($id) {
        $type = $_GET['type'] ?? 'sport';

        if($type === 'sport') {
            $eventModel = $this->model('EventSport');
            $creneauModel = $this->model('Creneau');

            $event = $eventModel->find($id);
            $creneaux = $creneauModel->getByEvent($id);

            $this->view('events/show', [
                'type' => $type,
                'event' => $event,
                'creneaux' => $creneaux
            ]);
        } else {
            $eventModel = $this->model('EventAsso');
            $event = $eventModel->find($id);

            if(!$event) {
                $this->flash("Événement introuvable.", "danger");
                $this->redirect('/evenements?type=' . $type);
                return;
            }

            // Vérifier l'accès pour les événements privés
            $is_adherent = false;
            if($this->isLogged()) {
                $membreModel = $this->model('Membre');
                $membre = $membreModel->find($_SESSION['user_id']);
                $is_adherent = $membre['adherent'];
            }

            if(!$eventModel->checkAccess($event, $is_adherent)) {
                if(!$this->isLogged()) {
                    $this->flash("Cet événement est réservé aux adhérents. Veuillez vous connecter.", "warning");
                    $this->redirect('/');
                } else {
                    $this->flash("Cet événement est réservé aux adhérents de l'association.", "danger");
                    $this->redirect('/evenements?type=asso');
                }
                return;
            }

            $this->view('events/show', [
                'type' => $type,
                'event' => $event
            ]);
        }
    }
}
