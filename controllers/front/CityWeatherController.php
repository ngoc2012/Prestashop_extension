<?php
namespace PrestaShop\Module\Weather\controllers\front;

require_once __DIR__ . '/../../models/City.php';
require_once __DIR__ . '/../../models/History.php';

use PrestaShop\Module\Weather\controllers\front\ViewController;
use PrestaShop\Module\Weather\controllers\front\ErrorController;

/**
* Controller for the city weather page
*/
class CityWeatherController extends ViewController {


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
		parent::initContent();
		try {
			$this->getData($this->city, $this->apiName);
		} catch (\RuntimeException $e) {
			ErrorController::init($e->getMessage());
			exit;
		}
		$histories = $this->city->getHistories();
		if (count($histories) == 0) {
			ErrorController::init('No weather history found for this city.');
			exit;
		}
		$this->context->smarty->assign(array(
			'histories' => $histories,
			'city' => $this->city,
			'history' => $histories[0],
			'homeLink' => $this->context->link->getPageLink('index'),
		));
		$this->setTemplate('module:weather/views/templates/front/cityWeather.tpl');
	}
}
