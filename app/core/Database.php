&lt;?php

/**
 * Classe Database - Gère la connexion à la base de données avec le pattern Singleton
 */
class Database {
    private static $instance = null;
    private $pdo;

    /**
     * Constructeur privé pour le pattern Singleton
     */
    private function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e) {
            die("Erreur BDD : " . $e->getMessage());
        }
    }

    /**
     * Récupère l'instance unique de la base de données
     * @return Database
     */
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Récupère la connexion PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->pdo;
    }
}
