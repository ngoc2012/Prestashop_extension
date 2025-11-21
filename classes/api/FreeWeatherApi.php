<?php

require_once __DIR__ . "/../../models/City.php";
require_once __DIR__ . "/../../models/History.php";
require_once __DIR__ . "/AbstractWeatherApi.php";
require_once __DIR__ . "/WeatherApiLogger.php";
require_once __DIR__ . "/WeatherApiRequest.php";
require_once __DIR__ . "/FreeWeatherResponseHandler.php";

use Certideal\RequestSender\Entity\BeanRequest\EmptyBeanRequest;
use Certideal\RequestSender\RequestSender;

/**
* FreeWeatherApi class to interact with the FreeWeather API
*/
class FreeWeatherApi extends AbstractWeatherApi {


	// ===================
	// === Constructor ===
	// ===================

	/**
	* Constructor allows overriding the API key and base URL.
	*
	* @param string|null $apiKey
	* @param string|null $baseUrl
	*/
	public function __construct($apiKey = null, $baseUrl = null, $uri = null) {
		parent::__construct();
		$this->apiName = "FreeWeatherApi";
		$this->apiKey  = $apiKey ?: ConfigurationCore::get('FREEWEATHER_API_KEY');
		$this->baseUrl = $baseUrl ?: ConfigurationCore::get('FREEWEATHER_BASE_URL');
		$this->uri = $uri ?: ConfigurationCore::get('FREEWEATHER_URI');
	}


	// ======================
	// === Public methods ===
	// ======================

	/**
	* Get weather data for a specified city.
	* @param \City $city
	* @return \History
	* @throws RuntimeException
	*/
	public function fetchWeather($city) {
		$cityNameEscaped = $city->encodeCityName();
		$sender = new RequestSender(
			$this->baseUrl,
			WeatherApiLogger::getInstance(),
			10,     // timeout 10 seconds
			true    // debug mode
		);
		// http://api.weatherapi.com/v1/current.json?key=d008...&q=Quang+Ninh&aqi=no
		$request = new \WeatherApiRequest(new EmptyBeanRequest(), [
			'key' => $this->apiKey,
			'q' => $cityNameEscaped,
			'aqi' => 'no'
		], null, $this->uri);
		$responseHandler = new FreeWeatherResponseHandler(WeatherApiLogger::getInstance(), $city, $this);
		$response = $sender->send($request, $responseHandler);
		return $response->getData();
	}
}
