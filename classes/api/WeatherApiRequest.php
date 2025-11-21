<?php

use Certideal\RequestSender\Entity\BeanRequest\BeanRequestInterface;
use Certideal\RequestSender\Entity\Request\AbstractRequest;

class WeatherApiRequest extends AbstractRequest {


	// =============
	// = Constants =
	// =============

	/**
	 * HTTP verb used for Weather API update requests.
	 */
	const WEATHER_API_VERB = self::HTTP_VERB_GET;


	// =================
	// === Variables ===
	// =================

	private $uri;


	// ===============
	// = Constructor =
	// ===============

	public function __construct(BeanRequestInterface $beanRequest, $queryParams = array(), $uriParam = null, $uri = null) {
		parent::__construct($beanRequest, $queryParams, $uriParam);
		$this->uri = $uri;
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
		return self::WEATHER_API_VERB;
	}

	/**
	 * Return configured URI with query params if needed
	 *
	 * @return string Formated URI
	 */
	public function getURI() {
		return $this->uri;
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
