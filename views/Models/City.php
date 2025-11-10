<?php
namespace PrestaShop\Module\Weather\Models;

use PrestaShopException;
use Db;
use ObjectModel;
use PrestaShopExceptionCore;
use Validate;
use ValidateCore;
/**
 * City model class
 */
class City extends ObjectModel {


    // =================
    // === Variables ===
    // =================

    /* @var string city name */
    private $name;
    /* @var string */
    private $visitedAt;

    public static $definition = [
        'table' => 'cities',
        'primary' => 'id',
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'unique' => true, 'size' => 100],
            'visitedAt' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
        ],
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
        //verif si name validation correct
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
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'cities WHERE name = "' . $name . '"';
        $cityData = Db::getInstance()->getRow($sql);
        if (!$cityData) {
            throw new PrestaShopExceptionCore("City with name '$name' not found.");
        }

        return new City($cityData['id']);
    }

    /**
     * Retrieve all cities from the database.
     * @return City[]
     */
    public static function findAll($limit = 10)
    {
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'cities ORDER BY visitedAt DESC';
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        $citiesData = Db::getInstance()->executeS($sql);
        $cities = [];
        foreach ($citiesData as $cityData) {
            $cities[] = new City($cityData['id']);
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
        $city->visitedAt = date('Y-m-d H:i:s');
        $city->add();
        return $city;
    }

    /**
     * Update the city's visitedAt timestamp to the current time.
     * @param int $id
     * @throws PrestaShopExceptionCore
     * @return void
     */
    public static function updateVisitedAt($id) {
        $city = new City($id);
        if (!ValidateCore::isLoadedObject($city)) {
            throw new PrestaShopExceptionCore("City with ID $id not found.");
        }
        $city->visitedAt = date('Y-m-d H:i:s');
        $city->update();
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

        if (isset($data['id']) && !is_numeric($data['id'])) {
            throw new PrestaShopExceptionCore("City ID must be numeric.");
        }

        $city = new City(isset($data['id']) ? (int)$data['id'] : null);
        $city->name = $data['name'];
        if (isset($data['visitedAt'])) {
            $city->visitedAt = $data['visitedAt'];
        }

        return $city;
    }
}
