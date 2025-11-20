<?php

use Certideal\RequestSender\Entity\Response\ResponseInterface;

class FreeWeatherResponse implements ResponseInterface {
	// =============
	// = Variables =
	// =============

	/** @var mixed */
	private $data;


	// ===============
	// = Constructor =
	// ===============


	public function __construct($data) {
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
