&lt;?php

/**
 * Contrôleur d'administration principal
 */
class AdminController extends Controller {

    /**
     * Tableau de bord administrateur
     */
    public function index() {
        $this->requireAdmin();

        $membreModel = $this->model('Membre');
        $eventSportModel = $this->model('EventSport');
        $eventAssoModel = $this->model('EventAsso');

        $statsMembers = $membreModel->getStats();
        $statsEvents = [
            'sport' => $eventSportModel->count(),
            'asso' => $eventAssoModel->count()
        ];

        $this->view('admin/index', [
            'statsMembers' => $statsMembers,
            'statsEvents' => $statsEvents
        ]);
    }

    /**
     * Gestion des membres
     */
    public function membres() {
        $this->requireAdmin();

        $membreModel = $this->model('Membre');
        $membres = $membreModel->getAll();

        $this->view('admin/membres', [
            'membres' => $membres,
            'csrf' => generateCSRF()
        ]);
    }

    /**
     * Valide un membre
     */
    public function validerMembre() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/membres');
            return;
        }

        $id = $_POST['id_membre'];
        $membreModel = $this->model('Membre');

        $membreModel->update($id, ['statut' => 'VALIDE']);
        $this->flash("Membre validé avec succès", "success");
        $this->redirect('/admin/membres');
    }

    /**
     * Change le statut adhérent
     */
    public function toggleAdherent() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/membres');
            return;
        }

        $id = $_POST['id_membre'];
        $adherent = $_POST['adherent'];
        $membreModel = $this->model('Membre');

        $membreModel->update($id, ['adherent' => $adherent]);
        $this->flash("Statut adhérent modifié", "success");
        $this->redirect('/admin/membres');
    }

    /**
     * Gestion des catégories
     */
    public function categories() {
        $this->requireAdmin();

        $categorieModel = $this->model('Categorie');
        $categories = $categorieModel->getAll();

        $this->view('admin/categories', [
            'categories' => $categories,
            'csrf' => generateCSRF()
        ]);
    }

    /**
     * Crée une catégorie
     */
    public function createCategorie() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/categories');
            return;
        }

        $libelle = trim($_POST['libelle']);
        $categorieModel = $this->model('Categorie');

        if($categorieModel->create($libelle)) {
            $this->flash("Catégorie créée avec succès", "success");
        } else {
            $this->flash("Erreur lors de la création", "danger");
        }

        $this->redirect('/admin/categories');
    }

    /**
     * Met à jour une catégorie
     */
    public function updateCategorie() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/categories');
            return;
        }

        $id = $_POST['id_cat_event'];
        $libelle = trim($_POST['libelle']);
        $categorieModel = $this->model('Categorie');

        if($categorieModel->update($id, $libelle)) {
            $this->flash("Catégorie modifiée avec succès", "success");
        } else {
            $this->flash("Erreur lors de la modification", "danger");
        }

        $this->redirect('/admin/categories');
    }

    /**
     * Supprime une catégorie
     */
    public function deleteCategorie() {
        $this->requireAdmin();

        if(!validateCSRF($_POST['csrf_token'])) {
            $this->flash("Token CSRF invalide", "danger");
            $this->redirect('/admin/categories');
            return;
        }

        $id = $_POST['id_cat_event'];
        $categorieModel = $this->model('Categorie');

        if($categorieModel->delete($id)) {
            $this->flash("Catégorie supprimée", "success");
        } else {
            $this->flash("Impossible de supprimer cette catégorie (utilisée par des événements)", "danger");
        }

        $this->redirect('/admin/categories');
    }
}
