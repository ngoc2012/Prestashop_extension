<?php
namespace App\Core;

use Config\AppConfig;
use PDO;

/**
 * Database class (singleton instance) to connect to the database
 */
class Database {

    // =================
    // === Variables ===
    // =================

    /* @var string host name localhost ...*/
    private $host;
    /* @var string database name */
    private $db;
    /* @var string database user */
    private $user;
    /* @var string database password */
    private $pass;
    /* @var string database charset */
    private $charset;
    /* @var PDO instance */
    private $pdo = null;
    /* @var string Data Source Name */
    private $dsn;
    /** @var array PDO options
     * - ERRMODE_EXCEPTION => throw exceptions on errors
     * - FETCH_ASSOC => results are associative arrays by default
     */
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    /** @var Database singleton instance */
    private static $instance = null;


    // ====================
    // === Constructors ===
    // ====================

    /**
     * Constructor
     * @param string $host
     * @param string $db
     * @param string $user
     * @param string $pass
     * @param string $charset
     */
    public function __construct($host = null, $db = null, $user = null, $pass = null, $charset = null) {
        $this->host = $host ?: AppConfig::DB_HOST;
        $this->db = $db ?: AppConfig::DB_NAME;
        $this->user = $user ?: AppConfig::DB_USER;
        $this->pass = $pass ?: AppConfig::DB_PASS;
        $this->charset = $charset ?: 'utf8mb4';
        $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
    }

    /**
     * Destructor to ensure the database connection is closed.
     */
    public function __destruct() {
        $this->closeConnection();
    }

    
    // =========================
    // === Public Methods ======
    // =========================

    /**
     * Get the singleton instance of the Database class.
     *
     * @return Database The singleton instance.
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Connect to the database and return the PDO instance.
     * 
     * @return PDO The PDO instance.
     */
    public function connect() {
        if ($this->pdo === null) {
            $this->pdo = new PDO($this->dsn, $this->user, $this->pass, $this->options);
        }
        return $this->pdo;
    }


    // =========================
    // === Private Methods =====
    // =========================
    
    /**
     * Close the database connection.
     *
     * @return void
     */
    private function closeConnection() {
        $this->pdo = null;
    }
}
