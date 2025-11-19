<?php

/**
* Base controller class to handle view rendering
*/
class weatherViewModuleFrontController extends \ModuleFrontController {

	public function __construct() {
		parent::__construct();
	}

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
			(new \weatherErrorModuleFrontController())->initContent($e->getMessage());
			exit;
		} catch (\Exception $e) { // catch anything else
			(new \weatherErrorModuleFrontController())->initContent('Unexpected error: ' . $e->getMessage());
			exit;
		}
	}

}
