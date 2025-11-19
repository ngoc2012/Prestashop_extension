<?php

require_once __DIR__ . '/TraitWeatherView.php';
require_once __DIR__ . '/../classes/City.php';
require_once __DIR__ . '/../classes/History.php';
require_once __DIR__ . '/ErrorController.php';

/**
 * Controller for the main page: Listing all the cities
 */
class CitiesList {

	use TraitWeatherView;

	private $methodName;

	public function __construct($methodName = 'post') {
		$this->methodName = $methodName;
	}

	// =========================
	// === Public Methods ======
	// =========================

	/**
	 * Display the list of cities.
	 *
	 * @return string HTML content
	 */
	public function initContent() {
		$context = ContextCore::getContext();
		$apiName = 'OpenWeatherMap';
		try {
			$cities = \City::findLastVisitedCities(10);
			if (count($cities) === 0) {
				$lastCity = new \City();
				$lastCity->name = 'Paris';
				$lastCity->add();
			} else {
				try {
					$lastHistory = \History::findLast();
					$apiName = $lastHistory->api;
					$lastCityId = $lastHistory->cityId;
				} catch (\PrestaShopException $e) {
					$lastCityId = $cities[0]->id_city;
				}
				$lastCity = new \City($lastCityId);
			}
		} catch (\PDOException $e) {
			ErrorController::initContent($e->getMessage());
			exit;
		} catch (\InvalidArgumentException $e) {
			ErrorController::initContent($e->getMessage());
			exit;
		}
		$history = self::getData($lastCity, $apiName);
		$link = $context->link->getModuleLink(
			'weather',
			'cityweather'
		);
		$context->smarty->assign(array(
			'method'   => $this->methodName,
			"city"     => $lastCity,
			"history"  => $history,
			"cities"   => $cities,
			"link"     => $link,
			"homeLink" => $context->link->getPageLink('index'),
		));

		return $context->smarty->fetch(_PS_MODULE_DIR_ . 'weather/views/templates/citiesList.tpl');
	}
}
