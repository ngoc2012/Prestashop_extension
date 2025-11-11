<?php
namespace PrestaShop\Module\Weather\Models;

use ObjectModel;
use PrestaShopExceptionCore;
use Db;
use ValidateCore;

/**
 * History model class with history records of weather data
 */
class History extends ObjectModel {

    // =================
    // === Variables ===
    // =================

    /* @var int city id */
    public $cityId;

    /* @var string API used */
    public $api;

    /* @var float temperature */
    public $temperature;

    /* @var float humidity */
    public $humidity;

    /* @var string created at */
    public $createdAt;


    // =========================
    // === ObjectModel setup ===
    // =========================

    public static $definition = [
        'table' =>  _DB_PREFIX_ . 'history',
        'primary' => 'id',
        'fields' => [
            'cityId'      => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true],
            'api'         => ['type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true],
            'temperature' => ['type' => self::TYPE_FLOAT, 'validate' => 'isFloat'],
            'humidity'    => ['type' => self::TYPE_FLOAT, 'validate' => 'isFloat'],
            'createdAt'   => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
        ],
    ];


    // ===========================
    // === Data access methods ===
    // ===========================

    /**
     * Find all histories for a city by its ID
     * @param int $cityId
     * @param int $limit
     * @return History[]
     * @throws PrestaShopExceptionCore
     */
    public static function findAllByCityId($cityId, $limit = 10) {
        $cityId = (int)$cityId;
        if ($cityId <= 0) {
            throw new PrestaShopExceptionCore("Invalid city ID: $cityId");
        }
        $sql = 'SELECT `id` FROM `' . _DB_PREFIX_ . 'history` 
                WHERE `cityId` = ' . $cityId . ' 
                ORDER BY `createdAt` DESC 
                LIMIT ' . (int)$limit;
        $ids = Db::getInstance()->executeS($sql);
        if (!$ids) {
            return [];
        }
        $histories = [];
        foreach ($ids as $row) {
            $history = new History($row['id']);
            if (ValidateCore::isLoadedObject($history)) {
                $histories[] = $history;
            }
        }
        return $histories;
    }

    /**
     * Find the latest history record for a city by its ID
     * @param int $cityId
     * @return History|null
     * @throws PrestaShopExceptionCore
     */
    public static function findLastByCityId($cityId) {
        $cityId = (int)$cityId;
        if ($cityId <= 0) {
            throw new PrestaShopExceptionCore("Invalid city ID: $cityId");
        }
        $sql = 'SELECT `id` FROM `' . _DB_PREFIX_ . 'history` 
                WHERE `cityId` = ' . $cityId . ' 
                ORDER BY `createdAt` DESC 
                LIMIT 1';

        $row = Db::getInstance()->getRow($sql);
        if (!$row) {
            return null; // No history record found
        }
        $history = new History($row['id']);
        if (!ValidateCore::isLoadedObject($history)) {
            throw new PrestaShopExceptionCore("Failed to load history record with ID " . $row['id']);
        }
        return $history;
    }

    /**
     * Find the latest history record overall
     * @return History|null
     * @throws PrestaShopExceptionCore
     */
    public static function findLast() {
        $sql = 'SELECT `id` FROM `' . _DB_PREFIX_ . 'history` 
                ORDER BY `createdAt` DESC 
                LIMIT 1';
        $row = Db::getInstance()->getRow($sql);
        if (!$row) {
            return null;
        }
        $history = new History($row['id']);
        if (!ValidateCore::isLoadedObject($history)) {
            throw new PrestaShopExceptionCore("Failed to load history record with ID " . $row['id']);
        }
        return $history;
    }

    /**
     * Save the history record to the database
     * @param History $history
     * @throws PrestaShopExceptionCore
     * @return void
     */
    public static function save2Db($history) {
        if (!$history instanceof History) {
            throw new PrestaShopExceptionCore('Invalid History object.');
        }
        if ((int)$history->cityId <= 0) {
            throw new PrestaShopExceptionCore('Invalid city ID.');
        }
        if (!ValidateCore::isName($history->api)) {
            throw new PrestaShopExceptionCore('Invalid API name.');
        }
        if (empty($history->createdAt)) {
            $history->createdAt = date('Y-m-d H:i:s');
        }
        if (!$history->add()) {
            throw new PrestaShopExceptionCore('Failed to save history record.');
        }
    }

    // ===========
    // === DTO ===
    // ===========

    /**
     * Transform data array to History object
     * @param array $data
     * @return History
     * @throws PrestaShopExceptionCore
     */
    public static function transformDataToHistory(array $data)
    {
        // Validate required fields
        $requiredFields = ['cityId', 'api', 'temperature', 'humidity'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new PrestaShopExceptionCore("Missing required field '$field' to transform to History object.");
            }
        }
        $city = new City($data['cityId']);
        if (!ValidateCore::isLoadedObject($city)) {
            throw new PrestaShopExceptionCore("City with ID " . $data['cityId'] . " does not exist.");
        }
        // Create new object (or load by ID if provided)
        $history = new History(isset($data['id']) ? (int)$data['id'] : null);
        // Assign properties manually
        $history->cityId = (int)$data['cityId'];
        $history->api = (string)$data['api'];
        $history->temperature = (float)$data['temperature'];
        $history->humidity = (float)$data['humidity'];
        $history->createdAt = isset($data['createdAt']) ? $data['createdAt'] : date('Y-m-d H:i:s');

        return $history;
    }

}
