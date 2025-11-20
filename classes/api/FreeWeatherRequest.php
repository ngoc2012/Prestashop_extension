<?php

namespace Api\Certicheck\Entity\Request;

use Certideal\RequestSender\Entity\BeanRequest\BeanRequestInterface;
use Certideal\RequestSender\Entity\Request\AbstractRequest;

class FreeWeatherRequest extends AbstractRequest {


	// ===============
	// = Constructor =
	// ===============

	public function __construct(BeanRequestInterface $beanRequest, $queryParams = array(), $uriParam = null) {
		parent::__construct($beanRequest, $queryParams, $uriParam);
	}


	// =====================
	// = Overrided Methods =
	// =====================

	/**
	 * Return HTTP verb
	 *
	 * @return string Request HTTP verb
	 */
	public function getHTTPVerb() {
		return self::HTTP_VERB_GET;
	}

	/**
	 * Return configured URI with query params if needed
	 *
	 * @return string Formated URI
	 */
	public function getURI() {
		return '';
	}

	/**
	 * Return configured URI with query params if needed
	 *
	 * @return string Formatted URI
	 */
	// http://api.weatherapi.com/v1/current.json?key=d0087dd7e57c4ed5b23142120250411&q=Quang+Ninh&aqi=no
	public function getURIWithParams() {
		$finalUri = $this->getURI();

		if ($uriParam = $this->getUriParam()) {
			$finalUri .=  . $this->getUriParam() . self::CERTICHECK_SECOND_URI;
		}

		return $finalUri;
	}

	/**
	 * Return Header specific collection
	 *
	 * @return array Associative array of header key values
	 */
	public function getHeaders() {
		return array();
	}

	/**
	 * Return Customer identifier
	 *
	 * @return string Request identifier
	 */
	public function getRequestIdentifier() {
		return __CLASS__;
	}
}
