<?php

require_once "History.php";

/**
 * City model class
 */
class City extends ObjectModel {


    // =================
    // === Variables ===
    // =================

    public $id_city;
    /* @var string city name */
    public $name;

    public static $definition = [
        'table' => 'city',
        'primary' => 'id_city',
        'fields' => [
            'id_city' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'unique' => true, 'size' => 100]
        ]
    ];


    // ======================
    // === Public methods ===
    // ======================

    /**
     * Encode the city name for URL usage.
     *
     * @return string The URL-encoded city name.
     */
    public function encodeCityName() {
        return urlencode($this->name);
    }

    public function setName($name) {
        if (!ValidateCore::isName($name)) {
            throw new PrestaShopExceptionCore("Invalid city name: '$name'.");
        }
        $this->name = pSQL($name);
        return $this;
    }

    // ===========================
    // === Data access methods ===
    // ===========================

    /**
     * Retrieve all history records for this city.
     * 
     * @return History[]
     */
    public function getHistories() {
        return History::findAllByCityId($this->id);
    }

    /**
     * Retrieve a city by its name.
     * @param string $name
     * @throws PrestaShopExceptionCore
     * @return City
     */
    public static function findByName($name)
    {
        // Sanitize input for SQL
        $name = pSQL($name);
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'city WHERE name = "' . $name . '"';
        $cityData = Db::getInstance()->getRow($sql);
        if (!$cityData) {
            throw new PrestaShopExceptionCore("City with name '$name' not found.");
        }

        return new City($cityData['id_city']);
    }

    /**
     * Retrieve the most recently visited cities.
     * @param int $limit
     * @return City[]
     */
    public static function findLastVisitedCities($limit = 10) {
        $limit = (int)$limit;
        $sql = "
            SELECT c.*
            FROM `" . _DB_PREFIX_ . "city` c
            LEFT JOIN (
                SELECT cityId, MAX(createdAt) AS lastVisit
                FROM `" . _DB_PREFIX_ . "history`
                GROUP BY cityId
            ) h ON c.id_city = h.cityId
            ORDER BY h.lastVisit DESC
            LIMIT $limit
        ";
        $citiesData = Db::getInstance()->executeS($sql);
        if (!$citiesData) {
            return [];
        }
        $cities = [];
        foreach ($citiesData as $row) {
            $cities[] = new City($row['id_city']);
        }
        return $cities;
    }

    /**
     * Save the city to the database.
     * @param string $cityName
     * @return City
     */
    public static function save2Db($cityName) {
        $city = new City();
        $city->setName($cityName);
        $city->add();
        return $city;
    }

    /**
     * Delete the city from the database.
     * @param int $id
     * @return void
     */
    public static function deleteDb($id) {
        $city = new City($id);
        $city->delete();
    }

    // ===========
    // === DTO ===
    // ===========

    /**
     * Transform data array to City object
     * @param array $data
     * @throws PrestaShopExceptionCore
     * @return City
     */
    public static function transformDataToCity(array $data)
    {
        if (!isset($data['name']) || !ValidateCore::isName($data['name'])) {
            throw new PrestaShopExceptionCore("Missing or invalid city name.");
        }

        if (isset($data['id_city']) && !is_numeric($data['id_city'])) {
            throw new PrestaShopExceptionCore("City ID must be numeric.");
        }

        $city = new City(isset($data['id_city']) ? (int)$data['id_city'] : null);
        $city->name = $data['name'];
        return $city;
    }
}
