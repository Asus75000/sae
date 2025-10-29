&lt;?php

/**
 * Modèle Creneau - Gère les créneaux des événements sportifs
 */
class Creneau {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Récupère tous les créneaux d'un événement sportif
     * @param int $id_event_sport
     * @return array
     */
    public function getByEvent($id_event_sport) {
        $stmt = $this->db->prepare("
            SELECT * FROM creneau_event
            WHERE id_event_sport = ?
            ORDER BY date_creneau, heure_debut
        ");
        $stmt->execute([$id_event_sport]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un créneau par son ID
     * @param int $id
     * @return array|false
     */
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM creneau_event WHERE id_creneau = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Récupère un créneau par ses détails
     * @param int $id_event_sport
     * @param string $date_creneau
     * @param string $heure_debut
     * @param string $heure_fin
     * @return array|false
     */
    public function findByDetails($id_event_sport, $date_creneau, $heure_debut, $heure_fin) {
        $stmt = $this->db->prepare("
            SELECT * FROM creneau_event
            WHERE id_event_sport = ? AND date_creneau = ? AND heure_debut = ? AND heure_fin = ?
        ");
        $stmt->execute([$id_event_sport, $date_creneau, $heure_debut, $heure_fin]);
        return $stmt->fetch();
    }

    /**
     * Crée un nouveau créneau
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO creneau_event (type, commentaire, date_creneau, heure_debut, heure_fin, id_event_sport)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['type'], $data['commentaire'], $data['date_creneau'],
            $data['heure_debut'], $data['heure_fin'], $data['id_event_sport']
        ]);
    }

    /**
     * Met à jour un créneau
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE creneau_event
            SET type = ?, commentaire = ?, date_creneau = ?, heure_debut = ?, heure_fin = ?
            WHERE id_creneau = ?
        ");
        return $stmt->execute([
            $data['type'], $data['commentaire'], $data['date_creneau'],
            $data['heure_debut'], $data['heure_fin'],
            $id
        ]);
    }

    /**
     * Supprime un créneau
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM creneau_event WHERE id_creneau = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Inscrit un membre à un créneau
     * @param int $id_creneau
     * @param int $id_membre
     * @return bool
     */
    public function registerUser($id_creneau, $id_membre) {
        $stmt = $this->db->prepare("INSERT IGNORE INTO aide_benevole (id_creneau, id_membre, presence) VALUES (?, ?, 0)");
        return $stmt->execute([$id_creneau, $id_membre]);
    }

    /**
     * Désinscrit un membre d'un créneau
     * @param int $id_creneau
     * @param int $id_membre
     * @return bool
     */
    public function unregisterUser($id_creneau, $id_membre) {
        $stmt = $this->db->prepare("DELETE FROM aide_benevole WHERE id_creneau = ? AND id_membre = ?");
        return $stmt->execute([$id_creneau, $id_membre]);
    }

    /**
     * Récupère les membres inscrits à un créneau
     * @param int $id_creneau
     * @return array
     */
    public function getRegisteredUsers($id_creneau) {
        $stmt = $this->db->prepare("
            SELECT m.*, ab.presence
            FROM aide_benevole ab
            JOIN membre m ON ab.id_membre = m.id_membre
            WHERE ab.id_creneau = ?
            ORDER BY m.nom, m.prenom
        ");
        $stmt->execute([$id_creneau]);
        return $stmt->fetchAll();
    }
}
