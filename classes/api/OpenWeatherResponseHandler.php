<?php

use Certideal\RequestSender\Entity\Response\ResponseInterface;

require_once __DIR__ . "/../../models/History.php";
require_once __DIR__ . "/WeatherApiResponse.php";
require_once __DIR__ . "/AbstractWeatherApiResponseHandler.php";

class OpenWeatherResponseHandler extends AbstractWeatherApiResponseHandler {


	// =====================
	// = Overrided Methods =
	// =====================

	/**
	 * {@inheritDoc}
	 * @see AbstractResponseHandler::loadObject($unserializedData)
	 * @return ResponseInterface
	 */
	protected function loadObject($unserializedData) {
		$history = new \History();
		$history->cityId = $this->city->id;
		$history->api = $this->api->getApiName();
		$history->temperature = $unserializedData['main']['temp'];
		$history->humidity = $unserializedData['main']['humidity'];
		$history->createdAt = date('Y-m-d H:i:s');
		$history->add();
		return new WeatherApiResponse($history);
	}
}
