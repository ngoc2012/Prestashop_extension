<?php
namespace PrestaShop\Module\Weather\controllers\front;

require_once __DIR__ . '/../../models/City.php';
require_once __DIR__ . '/../../models/History.php';

use PrestaShop\Module\Weather\services\WeatherService;
use RuntimeException;
use Exception;

/**
* Base controller class to handle view rendering
*/
abstract class AbstractViewController {
	
	protected $frontController;

	
	/**
	 * Constructor for AbstractViewController.
	 * @param FrontController $frontController
	 */
	public function __construct($frontController = null) {
		$this->frontController = $frontController;
	}
	
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
