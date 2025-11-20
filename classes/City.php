<?php

require_once "History.php";

/**
* City model class
*/
class City extends ObjectModel {


	// =================
	// === Variables ===
	// =================

	public $id;
	public $id_city;
	/* @var string city name */
	public $name;

	public static $definition = [
		'table' => 'city',
		'primary' => 'id_city',
		'fields' => [
			'id_city' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
			'name' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isName',
				'required' => true,
				'unique' => true,
				'size' => 100
		]]];


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
		* @throws PrestaShopException
		* @return City
		*/
		public static function findByName($name) {
			// Sanitize input for SQL
			$name = pSQL($name);
			$sql = 'SELECT * FROM ' . _DB_PREFIX_ . self::$definition['table']
				. ' WHERE name = "' . $name . '"';
			$cityData = Db::getInstance()->getRow($sql);
			if (!$cityData) {
				throw new PrestaShopException("City with name '$name' not found.");
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
				FROM `" . _DB_PREFIX_ . self::$definition['table'] . "` c
				LEFT JOIN `" . _DB_PREFIX_ . "history` h ON h.cityId = c.id_city
				GROUP BY c.id_city
				ORDER BY MAX(h.createdAt) DESC, c.id_city ASC
				LIMIT $limit;
        	";
			$cities = Db::getInstance()->executeS($sql);
			if (!$cities) {
				return [];
			}
			return ObjectModel::hydrateCollection(\City::class, $cities);
		}

	}
