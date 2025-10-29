&lt;?php

/**
 * Modèle Membre - Gère les membres de l'association
 */
class Membre {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Récupère un membre par son ID
     * @param int $id
     * @return array|false
     */
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM membre WHERE id_membre = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Récupère un membre par son email
     * @param string $email
     * @return array|false
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM membre WHERE mail = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Récupère tous les membres avec des filtres optionnels
     * @param array $filters
     * @return array
     */
    public function getAll($filters = []) {
        $sql = "SELECT * FROM membre WHERE 1=1";
        $params = [];

        if(isset($filters['statut'])) {
            $sql .= " AND statut = ?";
            $params[] = $filters['statut'];
        }
        if(isset($filters['adherent'])) {
            $sql .= " AND adherent = ?";
            $params[] = $filters['adherent'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Crée un nouveau membre
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO membre (prenom, nom, mail, mdp, telephone, taille_teeshirt, taille_pull, statut)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'ATTENTE')
        ");
        return $stmt->execute([
            $data['prenom'],
            $data['nom'],
            $data['mail'],
            password_hash($data['mdp'], PASSWORD_DEFAULT),
            $data['telephone'],
            $data['taille_teeshirt'],
            $data['taille_pull']
        ]);
    }

    /**
     * Met à jour un membre
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $sql = "UPDATE membre SET ";
        $params = [];
        $sets = [];

        foreach($data as $key => $value) {
            $sets[] = "$key = ?";
            $params[] = $value;
        }

        $sql .= implode(', ', $sets) . " WHERE id_membre = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Valide les données d'un membre
     * @param array $data
     * @return array
     */
    public function validate($data) {
        $errors = [];

        if(empty($data['prenom']) || strlen($data['prenom']) < 2) {
            $errors[] = "Le prénom doit contenir au moins 2 caractères.";
        }

        if(empty($data['nom']) || strlen($data['nom']) < 2) {
            $errors[] = "Le nom doit contenir au moins 2 caractères.";
        }

        if(!validateEmail($data['mail'])) {
            $errors[] = "L'adresse email n'est pas valide.";
        }

        if(isset($data['mdp']) && !validatePassword($data['mdp'])) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.";
        }

        if(!validatePhone($data['telephone'])) {
            $errors[] = "Le numéro de téléphone n'est pas valide (format attendu : 0XXXXXXXXX).";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Récupère les inscriptions d'un membre aux événements sportifs
     * @param int $id_membre
     * @return array
     */
    public function getInscriptionsEventsSport($id_membre) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT es.*, ce.libelle as categorie, c.type as type_creneau,
                   c.date_creneau, c.heure_debut, c.heure_fin, ab.presence
            FROM aide_benevole ab
            JOIN creneau_event c ON ab.id_creneau = c.id_creneau
            JOIN event_sport es ON c.id_event_sport = es.id_event_sport
            LEFT JOIN cat_event ce ON es.id_cat_event = ce.id_cat_event
            WHERE ab.id_membre = ?
            ORDER BY c.date_creneau DESC, c.heure_debut DESC
        ");
        $stmt->execute([$id_membre]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les inscriptions d'un membre aux événements associatifs
     * @param int $id_membre
     * @return array
     */
    public function getInscriptionsEventsAsso($id_membre) {
        $stmt = $this->db->prepare("
            SELECT ea.*, p.paiement_ok, p.nb_invites
            FROM participer p
            JOIN event_asso ea ON p.id_event_asso = ea.id_event_asso
            WHERE p.id_membre = ?
            ORDER BY ea.date_event_asso DESC
        ");
        $stmt->execute([$id_membre]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les statistiques des membres
     * @return array
     */
    public function getStats() {
        return [
            'total' => $this->db->query("SELECT COUNT(*) FROM membre")->fetchColumn(),
            'en_attente' => $this->db->query("SELECT COUNT(*) FROM membre WHERE statut='ATTENTE'")->fetchColumn(),
            'adherents' => $this->db->query("SELECT COUNT(*) FROM membre WHERE adherent=1")->fetchColumn()
        ];
    }
}
