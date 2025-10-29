&lt;?php

/**
 * Modèle EventAsso - Gère les événements associatifs
 */
class EventAsso {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Récupère tous les événements associatifs selon les droits
     * @param bool $admin_mode
     * @param int|null $user_id
     * @param bool $is_adherent
     * @return array
     */
    public function getAll($admin_mode = false, $user_id = null, $is_adherent = false) {
        if($admin_mode) {
            $stmt = $this->db->query("
                SELECT * FROM event_asso
                WHERE date_visible <= CURDATE()
                ORDER BY date_event_asso DESC
            ");
            return $stmt->fetchAll();
        }

        if(!$user_id) {
            $stmt = $this->db->query("
                SELECT * FROM event_asso
                WHERE date_visible <= CURDATE() AND prive = 0
                ORDER BY date_event_asso DESC
            ");
            return $stmt->fetchAll();
        }

        if($is_adherent) {
            $stmt = $this->db->query("
                SELECT * FROM event_asso
                WHERE date_visible <= CURDATE()
                ORDER BY date_event_asso DESC
            ");
        } else {
            $stmt = $this->db->query("
                SELECT * FROM event_asso
                WHERE date_visible <= CURDATE() AND prive = 0
                ORDER BY date_event_asso DESC
            ");
        }

        return $stmt->fetchAll();
    }

    /**
     * Récupère un événement associatif par son ID
     * @param int $id
     * @return array|false
     */
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM event_asso WHERE id_event_asso = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crée un nouvel événement associatif
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO event_asso (titre, descriptif, lieu_texte, lieu_maps, date_visible, date_cloture, tarif, prive, date_event_asso)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['titre'], $data['descriptif'],
            $data['lieu_texte'], $data['lieu_maps'],
            $data['date_visible'], $data['date_cloture'],
            $data['tarif'], $data['prive'], $data['date_event_asso']
        ]);
    }

    /**
     * Met à jour un événement associatif
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE event_asso
            SET titre = ?, descriptif = ?, lieu_texte = ?, lieu_maps = ?,
                date_visible = ?, date_cloture = ?, tarif = ?,
                prive = ?, date_event_asso = ?
            WHERE id_event_asso = ?
        ");
        return $stmt->execute([
            $data['titre'], $data['descriptif'],
            $data['lieu_texte'], $data['lieu_maps'],
            $data['date_visible'], $data['date_cloture'],
            $data['tarif'], $data['prive'], $data['date_event_asso'],
            $id
        ]);
    }

    /**
     * Supprime un événement associatif
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM event_asso WHERE id_event_asso = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Vérifie l'accès à un événement privé
     * @param array $event
     * @param bool $is_adherent
     * @return bool
     */
    public function checkAccess($event, $is_adherent) {
        if(!$event || !$event['prive']) {
            return true;
        }
        return $is_adherent;
    }

    /**
     * Inscrit un membre à un événement
     * @param int $id_membre
     * @param int $id_event_asso
     * @param int $nb_invites
     * @return bool
     */
    public function registerUser($id_membre, $id_event_asso, $nb_invites = 0) {
        $stmt = $this->db->prepare("SELECT date_event_asso FROM event_asso WHERE id_event_asso = ?");
        $stmt->execute([$id_event_asso]);
        $event = $stmt->fetch();

        $stmt = $this->db->prepare("
            INSERT INTO participer (id_membre, id_event_asso, paiement_ok, nb_invites, date_participation)
            VALUES (?, ?, 0, ?, ?)
        ");
        return $stmt->execute([$id_membre, $id_event_asso, $nb_invites, $event['date_event_asso']]);
    }

    /**
     * Désinscrit un membre d'un événement
     * @param int $id_membre
     * @param int $id_event_asso
     * @return bool
     */
    public function unregisterUser($id_membre, $id_event_asso) {
        $stmt = $this->db->prepare("DELETE FROM participer WHERE id_membre = ? AND id_event_asso = ?");
        return $stmt->execute([$id_membre, $id_event_asso]);
    }

    /**
     * Vérifie si un utilisateur est inscrit
     * @param int $id_membre
     * @param int $id_event_asso
     * @return bool
     */
    public function isUserRegistered($id_membre, $id_event_asso) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM participer WHERE id_membre = ? AND id_event_asso = ?");
        $stmt->execute([$id_membre, $id_event_asso]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Récupère les participants d'un événement
     * @param int $id_event_asso
     * @return array
     */
    public function getParticipants($id_event_asso) {
        $stmt = $this->db->prepare("
            SELECT m.*, p.paiement_ok, p.nb_invites
            FROM participer p
            JOIN membre m ON p.id_membre = m.id_membre
            WHERE p.id_event_asso = ?
        ");
        $stmt->execute([$id_event_asso]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les statistiques
     * @return int
     */
    public function count() {
        return $this->db->query("SELECT COUNT(*) FROM event_asso")->fetchColumn();
    }
}
