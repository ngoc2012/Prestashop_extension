<?php

require_once __DIR__ . "/../../models/City.php";

use Certideal\CertiLogger\CertiLogger;
use Certideal\PrestashopHelpers\CertidealAbstractService;

/**
* Base class for all WeatherApi type
*/
abstract class AbstractWeatherApi extends CertidealAbstractService { // implements WeatherApiInterface {


	// =================
	// === Variables ===
	// =================

	/* @var string */
	protected $apiKey;
	/* @var string */
	protected $baseUrl;
	/* @var string */
	protected $apiName;
	/** @var resource */
	protected $weatherApiContext;


	// ===================
	// === Constructor ===
	// ===================

	public function __construct() {
		$this->weatherApiContext = stream_context_create([
			'http' => [
				'ignore_errors' => true, // KEEP BODY even if HTTP 400/500
				'timeout' => 5,
			],
		]);
	}


	// ======================
	// === Public Methods ===
	// ======================

	public function getApiName() {
		return $this->apiName;
	}

	/**
	* Fetch weather data for a given city.
	*
	* @param \City $city The City object.
	*/
	abstract public function fetchWeather($city);


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
