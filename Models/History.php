<?php
namespace PrestaShop\Module\Weather\Models;

use PrestaShop\Module\Weather\Models\BaseModel;
use PrestaShop\Module\Weather\Core\Database;
use PDOException;
use InvalidArgumentException;
use Db;
/**
 * History model class with history records of weather data
 */
class History extends BaseModel {

    // =================
    // === Variables ===
    // =================

    /* @var int city id */
    private $cityId;

    /* @var string API used */
    private $api;

    /* @var float temperature */
    private $temperature;

    /* @var float humidity */
    private $humidity;

    /* @var string created at */
    private $createdAt;


    // ===================
    // === Constructor ===
    // ===================

    /**
     * Constructor
     * @param int $cityId
     * @param string $api
     * @param float $temperature
     * @param float $humidity
     * @param string $createdAt
     * @throws InvalidArgumentException
     */
    public function __construct($id=0, $cityId, $api, $temperature, $humidity, $createdAt) {
        if (!is_numeric($temperature)) {
            throw new InvalidArgumentException("Temperature value is not numeric.");
        }
        if (!is_numeric($humidity)) {
            throw new InvalidArgumentException("Humidity value is not numeric.");
        }
        if ($temperature < -100 || $temperature > 100) {
            throw new InvalidArgumentException("Temperature value is invalid.");
        }
        if ($humidity < 0 || $humidity > 100) {
            throw new InvalidArgumentException("Humidity value is invalid.");
        }
        parent::__construct($id);
        $this->cityId = $cityId;
        $this->api = $api;
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->createdAt = $createdAt;
    }


    // ===============
    // === Getters ===
    // ===============

    public function getCityId() {
        return $this->cityId;
    }
    public function getApi() {
        return $this->api;
    }
    public function getTemperature() {
        return $this->temperature;
    }
    public function getHumidity() {
        return $this->humidity;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }


    // ===========================
    // === Data access methods ===
    // ===========================

    /**
     * Find all the histories of a city by its id
     * @param int $id
     * @throws PDOException
     * @return History[]
     */
    public static function findAllById($id) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "history WHERE cityId = " . (int)$id . " ORDER BY createdAt DESC LIMIT 10";
        $historyData = Db::getInstance()->executeS($sql);
        $history = [];
        foreach ($historyData as &$record) {
            $history[] = History::transformDataToHistory($record);
        }
        return $history;
    }

    /**
     * Find last the histories of a city by its id
     * @param int $id
     * @throws PDOException
     * @return History|null
     */
    public static function findLastById($id) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "history WHERE cityId = " . (int)$id . " ORDER BY createdAt DESC LIMIT 1";
        $historyData = Db::getInstance()->getRow($sql);
        if ($historyData) {
            return History::transformDataToHistory($historyData);
        }
    }

    /**
     * Save the history record on the database
     * @param History $weatherData
     * @throws PDOException
     * @return void
     */
    public static function save($weatherData) {
        $database = Database::getInstance()->connect();
        $PDOStatement = $database->prepare("
            INSERT INTO " . _DB_PREFIX_ . "history (cityId, api, temperature, humidity, createdAt)
            VALUES (:cityId, :api, :temperature, :humidity, NOW())
        ");
        if (!$PDOStatement) {
            throw new PDOException("Failed to prepare statement for saving history record.");
        }
        $result = $PDOStatement->execute([
            ':cityId'      => $weatherData->getCityId(),
            ':api'         => $weatherData->getApi(),
            ':temperature' => $weatherData->getTemperature(),
            ':humidity'    => $weatherData->getHumidity()
        ]);
        if (!$result) {
            throw new PDOException("Failed to save history record.");
        }
    }

    // ===========
    // === DTO ===
    // ===========

    /**
     * Transform data array to History object
     * @param array $data
     * @throws InvalidArgumentException
     * @return History
     */
    public static function transformDataToHistory($data) {
        if (!is_array($data)) {
            throw new InvalidArgumentException("Data must be an array to transform to History object.");
        }
        if (!isset($data['cityId'], $data['api'], $data['temperature'], $data['humidity'])) {
            throw new InvalidArgumentException("Missing required data fields to transform to History object.");
        }
        return new History(
            isset($data['id']) ? (int)$data['id'] : 0,
            $data['cityId'],
            $data['api'],
            $data['temperature'],
            $data['humidity'],
            isset($data['createdAt']) ? $data['createdAt'] : date('Y-m-d H:i:s')
        );
    }
}
