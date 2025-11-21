<?php

require_once __DIR__ . '/../models/City.php';
require_once __DIR__ . '/../models/History.php';
require_once __DIR__ . '/ErrorController.php';
require_once __DIR__ . '/../classes/WeatherService.php';

use Certideal\CertiLogger\CertiLogger;
use Certideal\PrestashopHelpers\CertidealAbstractService;
use Certideal\RequestSender\Common\RequestSenderException;

/**
 * Controller for the main page: Listing all the cities
 */
class CitiesList extends CertidealAbstractService {


	// =========================
	// === Variables ===========
	// =========================

	private $methodName;


	// =========================
	// === Constructor ========
	// =========================

	public function __construct($methodName = 'post') {
		$this->methodName = $methodName;
	}


	// =========================
	// === Public Methods ======
	// =========================

	/**
	 * Display the list of cities.
	 *
	 * @return void
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
					$lastCityId = $cities[0]->id;
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
		try {
			$history = WeatherService::getData($lastCity, $apiName);
			$link = $context->link->getModuleLink(
				'weather',
				'cityweather'
			);
			$context->smarty->assign(array(
				"weather_method"   => $this->methodName,
				"weather_city"     => $lastCity,
				"weather_history"  => $history,
				"weather_cities"   => $cities,
				"weather_link"     => $link,
				"weather_homeLink" => $context->link->getPageLink('index'),
			));

			$context->smarty->display(_PS_MODULE_DIR_ . 'weather/views/templates/citiesList.tpl');
		} catch (RequestSenderException $e) {
			ErrorController::initContent($e->getMessage());
			exit;
		} catch (Exception $e) {
			ErrorController::initContent("Unexpected error: " . $e->getMessage());
			exit;
		}
	}


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
