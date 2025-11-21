<?php

require_once __DIR__ . "/../../models/City.php";
require_once __DIR__ . "/WeatherApiResponse.php";

use Certideal\RequestSender\Http\AbstractResponseHandler;

abstract class AbstractWeatherApiResponseHandler extends AbstractResponseHandler {


	// =================
	// === Variables ===
	// =================

	/* @var \City */
	protected $city;
	/* @var AbstractWeatherApi */
	protected $api;


	public function __construct($logger = null, $city = null, $api = null) {
		parent::__construct($logger);
		$this->city = $city;
		$this->api = $api;
	}
}
