<?php

/**
* Controller for the city weather page
*/
class WeatherCityWeatherModuleFrontController extends WeatherViewModuleFrontController {


	// =================
	// === Variables ===
	// =================

	/* @var City */
	public $city;
	/* @var string */
	public $apiName;


	// ===================
	// === Constructor ===
	// ===================

	/**
	* Constructor for the CityWeatherController.
	* @param string $viewType
	* @param \City $city
	* @param string $apiName
	*/
	public function __construct(\City $city, $apiName) {
		parent::__construct();
		$this->city = $city;
		$this->apiName = $apiName;
	}


	// ======================
	// === Public Methods ===
	// ======================

	/**
	* Get the weather data for a specific city and display it.
	*
	* @return void
	*/
	public function initContent() {
		$this->context = \ContextCore::getContext();
		parent::initContent();
		try {
			$this->getData($this->city, $this->apiName);
		} catch (\RuntimeException $e) {
			(new WeatherErrorModuleFrontController())->initContent($e->getMessage());
			exit;
		}
		$histories = $this->city->getHistories();
		if (count($histories) == 0) {
			(new WeatherErrorModuleFrontController())->initContent('No history found for this city.');
			exit;
		}
		// $context = ContextCore::getContext();
		// $context->smarty->assign('histories', $histories);
		// $context->smarty->assign('city', $this->city);
		// $context->smarty->assign('history', $histories[0]);
		// $context->smarty->assign('homeLink', $context->link->getPageLink('index'));
		// $context->smarty->display('front/cityWeather.tpl');
		$this->context->smarty->assign(array(
			'histories' => $histories,
			'city' => $this->city,
			'history' => $histories[0],
			'homeLink' => $this->context->link->getPageLink('index'),
		));
		$this->setTemplate('module:weather/views/templates/front/cityWeather.tpl');
	}
}
