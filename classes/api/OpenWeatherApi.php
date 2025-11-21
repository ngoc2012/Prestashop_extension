<?php

require_once __DIR__ . "/../../models/City.php";
require_once __DIR__ . "/../../models/History.php";
require_once __DIR__ . "/AbstractWeatherApi.php";
require_once __DIR__ . "/WeatherApiLogger.php";
require_once __DIR__ . "/WeatherApiRequest.php";
require_once __DIR__ . "/OpenWeatherResponseHandler.php";

use Certideal\RequestSender\Entity\BeanRequest\EmptyBeanRequest;
use Certideal\RequestSender\RequestSender;

/**
* OpenWeatherApi class to interact with the OpenWeather API
*/
class OpenWeatherApi extends AbstractWeatherApi {


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
		$this->apiName = "OpenWeatherApi";
		$this->apiKey  = $apiKey ?: ConfigurationCore::get('OPENWEATHER_API_KEY');
		$this->baseUrl = $baseUrl ?: ConfigurationCore::get('OPENWEATHER_BASE_URL');
		$this->uri = $uri ?: ConfigurationCore::get('OPENWEATHER_URI');
	}


	// ======================
	// === Public methods ===
	// ======================

	/**
	* Get weather data for a specified city.
	* @param \City $city
	* @return [float, float]
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
		// https://api.openweathermap.org/data/2.5/weather?q=Quang+Ninh&units=metric&lang=en&appid=6bd83...
		$request = new \WeatherApiRequest(new EmptyBeanRequest(), [
			'appid' => $this->apiKey,
			'q' => $cityNameEscaped,
			'units' => "metric",
			'lang' => 'en'
		], null, $this->uri);
		$responseHandler = new OpenWeatherResponseHandler(WeatherApiLogger::getInstance(), $city, $this);
		$response = $sender->send($request, $responseHandler);
		return $response->getData();
	}
}
