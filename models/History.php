<?php

require_once "City.php";

use Certideal\CertiLogger\CertiLogger;
use Certideal\PrestashopHelpers\CertidealAbstractObjectModel;

/**
* History model class with history records of weather data
*/
class History extends CertidealAbstractObjectModel {

	// =================
	// === Variables ===
	// =================

	/* @var int city ID */
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
		'table' =>  'history',
		'primary' => 'id_history',
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
	* @throws PrestaShopException
	*/
	public static function findAllByCityId($cityId, $limit = 10) {
		$cityId = (int)$cityId;
		if ($cityId <= 0) {
			throw new PrestaShopException("Invalid city ID: $cityId");
		}
		$sql = 'SELECT `id_history` FROM `' . _DB_PREFIX_ . self::$definition['table'] . '` 
 			WHERE `cityId` = ' . $cityId . ' 
 			ORDER BY `createdAt` DESC 
 			LIMIT ' . (int)$limit;
		$ids = Db::getInstance()->executeS($sql);
		if (!$ids) {
			return [];
		}
		$histories = [];
		foreach ($ids as $row) {
			$history = new History($row['id_history']);
			if (ValidateCore::isLoadedObject($history)) {
				$histories[] = $history;
			}
		}
		return $histories;
	}

	/**
	* Find the latest history record overall
	* @throws PrestaShopException
	* @return History
	*/
	public static function findLast() {
		$sql = 'SELECT `id_history` FROM `' . _DB_PREFIX_ . self::$definition['table'] . '` 
			ORDER BY `createdAt` DESC';
		$row = Db::getInstance()->getRow($sql);
		if (!$row) {
			throw new PrestaShopException("No history records found.");
		}
		$history = new History($row['id_history']);
		if (!ValidateCore::isLoadedObject($history)) {
			throw new PrestaShopException("Failed to load history record with ID " . $row['id_history']);
		}
		return $history;
	}


	// =====================
	// = Overrided Methods =
	// =====================

	/**
	 * {@inheritDoc}
	 * @see \Certideal\PrestashopHelpers\CertidealAbstractObjectModel::getLoggerSection()
	 */
	protected function getLoggerSection() {
		return CertiLogger::LOGGER_LEVEL_INFO;
	}

}
