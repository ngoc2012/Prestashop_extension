<?php
namespace PrestaShop\Module\Weather\controllers\front;

require_once __DIR__ . '/../../models/City.php';
require_once __DIR__ . '/../../models/History.php';

use PrestaShop\Module\Weather\services\WeatherService;
use PrestaShop\Module\Weather\controllers\front\ErrorController;

/**
* Base controller class to handle view rendering
*/
class ViewController extends \ModuleFrontController {

	public function initContent() {
		parent::initContent();
	}

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
		} catch (\RuntimeException $e) {
			if (count($city->getHistories()) === 0) {
				$city->delete();
			}
			ErrorController::init($e->getMessage());
			exit;
		} catch (\Exception $e) { // catch anything else
			ErrorController::init('Unexpected error: ' . $e->getMessage());
			exit;
		}
	}

}
