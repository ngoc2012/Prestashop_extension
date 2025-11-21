<?php

require_once __DIR__ . "/../../models/History.php";

use Certideal\RequestSender\Entity\Response\ResponseInterface;

class WeatherApiResponse implements ResponseInterface {


	// =============
	// = Variables =
	// =============

	/** @var History */
	private $data;


	// ===============
	// = Constructor =
	// ===============


	public function __construct(History $data) {
		$this->data = $data;
	}


	// ==========================
	// ==== Getters & Setters ===
	// ==========================

	/**
	 * get data
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}
}
