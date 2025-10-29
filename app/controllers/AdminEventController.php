&lt;?php

/**
 * Contrôleur d'administration des événements
 */
class AdminEventController extends Controller {

    /**
     * Liste des événements sportifs
     */
    public function eventsSport() {
        $this->requireAdmin();

        $eventModel = $this->model('EventSport');
        $categorieModel = $this->model('Categorie');

        $events = $eventModel->getAll();
        $categories = $categorieModel->getAll();

        $this->view('admin/events_sport', [
            'events' => $events,
            'categories' => $categories,
            'csrf' => generateCSRF()
        ]);
    }

    /**
     * Liste des événements associatifs
     */
    public function eventsAsso() {
        $this->requireAdmin();

        $eventModel = $this->model('EventAsso');
        $events = $eventModel->getAll(true);

        $this->view('admin/events_asso', [
            'events' => $events,
            'csrf' => generateCSRF()
        ]);
    }

    /**
     * Crée un événement sportif
     */
    public function createEventSport() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/events-sport');
            return;
        }

        $eventModel = $this->model('EventSport');

        $data = [
            'titre' => trim($_POST['titre']),
            'descriptif' => trim($_POST['descriptif']),
            'lieu_texte' => trim($_POST['lieu_texte']),
            'lieu_maps' => trim($_POST['lieu_maps']),
            'date_visible' => $_POST['date_visible'],
            'date_cloture' => $_POST['date_cloture'],
            'id_cat_event' => $_POST['id_cat_event']
        ];

        if($eventModel->create($data)) {
            $this->flash("Événement sportif créé avec succès", "success");
        } else {
            $this->flash("Erreur lors de la création", "danger");
        }

        $this->redirect('/admin/events-sport');
    }

    /**
     * Met à jour un événement sportif
     */
    public function updateEventSport() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/events-sport');
            return;
        }

        $id = $_POST['id_event_sport'];
        $eventModel = $this->model('EventSport');

        $data = [
            'titre' => trim($_POST['titre']),
            'descriptif' => trim($_POST['descriptif']),
            'lieu_texte' => trim($_POST['lieu_texte']),
            'lieu_maps' => trim($_POST['lieu_maps']),
            'date_visible' => $_POST['date_visible'],
            'date_cloture' => $_POST['date_cloture'],
            'id_cat_event' => $_POST['id_cat_event']
        ];

        if($eventModel->update($id, $data)) {
            $this->flash("Événement sportif modifié avec succès", "success");
        } else {
            $this->flash("Erreur lors de la modification", "danger");
        }

        $this->redirect('/admin/events-sport');
    }

    /**
     * Supprime un événement sportif
     */
    public function deleteEventSport() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/events-sport');
            return;
        }

        $id = $_POST['id_event_sport'];
        $eventModel = $this->model('EventSport');

        if($eventModel->delete($id)) {
            $this->flash("Événement sportif supprimé", "success");
        } else {
            $this->flash("Erreur lors de la suppression", "danger");
        }

        $this->redirect('/admin/events-sport');
    }

    /**
     * Crée un événement associatif
     */
    public function createEventAsso() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/events-asso');
            return;
        }

        $eventModel = $this->model('EventAsso');

        $data = [
            'titre' => trim($_POST['titre']),
            'descriptif' => trim($_POST['descriptif']),
            'lieu_texte' => trim($_POST['lieu_texte']),
            'lieu_maps' => trim($_POST['lieu_maps']),
            'date_visible' => $_POST['date_visible'],
            'date_cloture' => $_POST['date_cloture'],
            'tarif' => floatval($_POST['tarif']),
            'prive' => isset($_POST['prive']) ? 1 : 0,
            'date_event_asso' => $_POST['date_event_asso']
        ];

        if($eventModel->create($data)) {
            $this->flash("Événement associatif créé avec succès", "success");
        } else {
            $this->flash("Erreur lors de la création", "danger");
        }

        $this->redirect('/admin/events-asso');
    }

    /**
     * Met à jour un événement associatif
     */
    public function updateEventAsso() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/events-asso');
            return;
        }

        $id = $_POST['id_event_asso'];
        $eventModel = $this->model('EventAsso');

        $data = [
            'titre' => trim($_POST['titre']),
            'descriptif' => trim($_POST['descriptif']),
            'lieu_texte' => trim($_POST['lieu_texte']),
            'lieu_maps' => trim($_POST['lieu_maps']),
            'date_visible' => $_POST['date_visible'],
            'date_cloture' => $_POST['date_cloture'],
            'tarif' => floatval($_POST['tarif']),
            'prive' => isset($_POST['prive']) ? 1 : 0,
            'date_event_asso' => $_POST['date_event_asso']
        ];

        if($eventModel->update($id, $data)) {
            $this->flash("Événement associatif modifié avec succès", "success");
        } else {
            $this->flash("Erreur lors de la modification", "danger");
        }

        $this->redirect('/admin/events-asso');
    }

    /**
     * Supprime un événement associatif
     */
    public function deleteEventAsso() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/events-asso');
            return;
        }

        $id = $_POST['id_event_asso'];
        $eventModel = $this->model('EventAsso');

        if($eventModel->delete($id)) {
            $this->flash("Événement associatif supprimé", "success");
        } else {
            $this->flash("Erreur lors de la suppression", "danger");
        }

        $this->redirect('/admin/events-asso');
    }
}
