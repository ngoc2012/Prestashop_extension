<?php
namespace PrestaShop\Module\Weather\MyControllers;

require_once __DIR__ . '/../classes/City.php';
require_once __DIR__ . '/../classes/History.php';

use PrestaShop\Module\Weather\Services\WeatherService;
use RuntimeException;
use Exception;

/**
* Base controller class to handle view rendering
*/
abstract class AbstractViewController {
	
	
	// ========================
	// === Abstract Methods ===
	// ========================
	
	/**
	* Abstract init method to be implemented by subclasses
	*/
	abstract public function init();
	
	
	// =========================
	// === Protected Methods ===
	// =========================
	
	/**
	* Get weather data for a city using specified API.
	* @param \City $city
	* @param string $apiName
	* @return \History
	*/
	protected static function getData($city, $apiName) {
		try {
			$lastHistory = WeatherService::getData($city, $apiName);
			return $lastHistory;
		} catch (RuntimeException $e) {
			if (count($city->getHistories()) === 0) {
				$city->delete();
			}
			ErrorController::init($e->getMessage());
			exit;
		} catch (Exception $e) { // catch anything else
			ErrorController::init('Unexpected error: ' . $e->getMessage());
			exit;
		}
	}
	
}
