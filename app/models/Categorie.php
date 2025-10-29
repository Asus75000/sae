&lt;?php

/**
 * Modèle Categorie - Gère les catégories d'événements sportifs
 */
class Categorie {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Récupère toutes les catégories
     * @return array
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM cat_event ORDER BY libelle ASC");
        return $stmt->fetchAll();
    }

    /**
     * Récupère une catégorie par son ID
     * @param int $id
     * @return array|false
     */
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM cat_event WHERE id_cat_event = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crée une nouvelle catégorie
     * @param string $libelle
     * @return bool
     */
    public function create($libelle) {
        $stmt = $this->db->prepare("INSERT INTO cat_event (libelle) VALUES (?)");
        return $stmt->execute([$libelle]);
    }

    /**
     * Met à jour une catégorie
     * @param int $id
     * @param string $libelle
     * @return bool
     */
    public function update($id, $libelle) {
        $stmt = $this->db->prepare("UPDATE cat_event SET libelle = ? WHERE id_cat_event = ?");
        return $stmt->execute([$libelle, $id]);
    }

    /**
     * Compte le nombre d'événements utilisant cette catégorie
     * @param int $id_cat_event
     * @return int
     */
    public function countEvents($id_cat_event) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM event_sport WHERE id_cat_event = ?");
        $stmt->execute([$id_cat_event]);
        return $stmt->fetchColumn();
    }

    /**
     * Supprime une catégorie (si non utilisée)
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        if($this->countEvents($id) > 0) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM cat_event WHERE id_cat_event = ?");
        return $stmt->execute([$id]);
    }
}
