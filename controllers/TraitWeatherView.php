<?php

require_once __DIR__ . '/../services/WeatherService.php';
require_once __DIR__ . '/ErrorController.php';

/**
* Base controller class to handle view rendering
*/
trait TraitWeatherView {


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
			ErrorController::initContent($e->getMessage());
			exit;
		} catch (\Exception $e) { // catch anything else
			ErrorController::initContent('Unexpected error: ' . $e->getMessage());
			exit;
		}
	}

}
