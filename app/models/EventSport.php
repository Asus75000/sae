&lt;?php

/**
 * Modèle EventSport - Gère les événements sportifs
 */
class EventSport {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Récupère tous les événements sportifs visibles
     * @return array
     */
    public function getAll() {
        $stmt = $this->db->query("
            SELECT es.*, ce.libelle as categorie
            FROM event_sport es
            LEFT JOIN cat_event ce ON es.id_cat_event = ce.id_cat_event
            WHERE date_visible <= CURDATE()
            ORDER BY date_cloture DESC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Récupère un événement sportif par son ID
     * @param int $id
     * @return array|false
     */
    public function find($id) {
        $stmt = $this->db->prepare("
            SELECT es.*, ce.libelle as categorie
            FROM event_sport es
            LEFT JOIN cat_event ce ON es.id_cat_event = ce.id_cat_event
            WHERE id_event_sport = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crée un nouvel événement sportif
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO event_sport (titre, descriptif, lieu_texte, lieu_maps, date_visible, date_cloture, id_cat_event)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['titre'], $data['descriptif'],
            $data['lieu_texte'], $data['lieu_maps'],
            $data['date_visible'], $data['date_cloture'], $data['id_cat_event']
        ]);
    }

    /**
     * Met à jour un événement sportif
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE event_sport
            SET titre = ?, descriptif = ?, lieu_texte = ?, lieu_maps = ?,
                date_visible = ?, date_cloture = ?, id_cat_event = ?
            WHERE id_event_sport = ?
        ");
        return $stmt->execute([
            $data['titre'], $data['descriptif'],
            $data['lieu_texte'], $data['lieu_maps'],
            $data['date_visible'], $data['date_cloture'], $data['id_cat_event'],
            $id
        ]);
    }

    /**
     * Supprime un événement sportif
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM event_sport WHERE id_event_sport = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Vérifie si un utilisateur est inscrit à cet événement
     * @param int $id_membre
     * @param int $id_event_sport
     * @return bool
     */
    public function isUserRegistered($id_membre, $id_event_sport) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM aide_benevole ab
            JOIN creneau_event c ON ab.id_creneau = c.id_creneau
            WHERE ab.id_membre = ? AND c.id_event_sport = ?
        ");
        $stmt->execute([$id_membre, $id_event_sport]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Désinscrit un membre de tous les créneaux d'un événement
     * @param int $id_event_sport
     * @param int $id_membre
     * @return bool
     */
    public function unregisterUser($id_event_sport, $id_membre) {
        $stmt = $this->db->prepare("
            DELETE FROM aide_benevole
            WHERE id_membre = ?
            AND id_creneau IN (SELECT id_creneau FROM creneau_event WHERE id_event_sport = ?)
        ");
        return $stmt->execute([$id_membre, $id_event_sport]);
    }

    /**
     * Récupère les statistiques
     * @return int
     */
    public function count() {
        return $this->db->query("SELECT COUNT(*) FROM event_sport")->fetchColumn();
    }
}
