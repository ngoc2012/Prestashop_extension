<?php

require_once __DIR__ . '/../classes/City.php';
require_once __DIR__ . '/../classes/History.php';
require_once __DIR__ . '/api/FreeWeatherApi.php';
require_once __DIR__ . '/api/OpenWeatherApi.php';

/**
* WeatherService class to fetch weather data
*/
class WeatherService {


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
	}
