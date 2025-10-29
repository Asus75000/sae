&lt;?php

/**
 * Contrôleur d'administration des créneaux
 */
class AdminCreneauController extends Controller {

    /**
     * Gestion des créneaux
     */
    public function index() {
        $this->requireAdmin();

        $id_event = $_GET['event'] ?? null;

        if(!$id_event) {
            $this->redirect('/admin/events-sport');
            return;
        }

        $eventModel = $this->model('EventSport');
        $creneauModel = $this->model('Creneau');

        $event = $eventModel->find($id_event);
        $creneaux = $creneauModel->getByEvent($id_event);

        $this->view('admin/creneaux', [
            'event' => $event,
            'creneaux' => $creneaux,
            'csrf' => generateCSRF()
        ]);
    }

    /**
     * Crée un créneau
     */
    public function create() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/creneaux?event=' . $_POST['id_event_sport']);
            return;
        }

        $creneauModel = $this->model('Creneau');

        $data = [
            'type' => trim($_POST['type']),
            'commentaire' => trim($_POST['commentaire']),
            'date_creneau' => $_POST['date_creneau'],
            'heure_debut' => $_POST['heure_debut'],
            'heure_fin' => $_POST['heure_fin'],
            'id_event_sport' => $_POST['id_event_sport']
        ];

        if($creneauModel->create($data)) {
            $this->flash("Créneau créé avec succès", "success");
        } else {
            $this->flash("Erreur lors de la création", "danger");
        }

        $this->redirect('/admin/creneaux?event=' . $_POST['id_event_sport']);
    }

    /**
     * Met à jour un créneau
     */
    public function update() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/creneaux?event=' . $_POST['id_event_sport']);
            return;
        }

        $id = $_POST['id_creneau'];
        $creneauModel = $this->model('Creneau');

        $data = [
            'type' => trim($_POST['type']),
            'commentaire' => trim($_POST['commentaire']),
            'date_creneau' => $_POST['date_creneau'],
            'heure_debut' => $_POST['heure_debut'],
            'heure_fin' => $_POST['heure_fin']
        ];

        if($creneauModel->update($id, $data)) {
            $this->flash("Créneau modifié avec succès", "success");
        } else {
            $this->flash("Erreur lors de la modification", "danger");
        }

        $this->redirect('/admin/creneaux?event=' . $_POST['id_event_sport']);
    }

    /**
     * Supprime un créneau
     */
    public function delete() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/creneaux?event=' . $_POST['id_event_sport']);
            return;
        }

        $id = $_POST['id_creneau'];
        $creneauModel = $this->model('Creneau');

        if($creneauModel->delete($id)) {
            $this->flash("Créneau supprimé", "success");
        } else {
            $this->flash("Erreur lors de la suppression", "danger");
        }

        $this->redirect('/admin/creneaux?event=' . $_POST['id_event_sport']);
    }
}
