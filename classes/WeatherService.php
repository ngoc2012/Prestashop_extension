<?php

require_once __DIR__ . '/../models/City.php';
require_once __DIR__ . '/../models/History.php';
require_once __DIR__ . '/api/FreeWeatherApi.php';
require_once __DIR__ . '/api/OpenWeatherApi.php';

use Certideal\CertiLogger\CertiLogger;
use Certideal\PrestashopHelpers\CertidealAbstractService;

/**
* WeatherService class to fetch weather data
*/
class WeatherService extends CertidealAbstractService {


	// ======================
	// === Public methods ===
	// ======================

	/**
	* Fetch weather metrics for a given city using the specified API.
	*
	* @param \City $city The City object.
	* @param string|null $apiName The name of the API to use (optional).
	* @return \History
	*/
	public static function getData($city, $apiName = null) {
		switch ($apiName) {
			case 'FreeWeatherApi':
				$api = new \FreeWeatherApi();
				break;
				default:
				$api = new \OpenWeatherApi();
				break;
		}
		list($temperature, $humidity) = $api->fetchWeather($city);
		$history = new \History();
		$history->cityId = $city->id;
		$history->api = $api->getApiName();
		$history->temperature = $temperature;
		$history->humidity = $humidity;
		$history->createdAt = date('Y-m-d H:i:s');
		$history->add();
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