<?php
namespace PrestaShop\Module\Weather\controllers\front;

require_once __DIR__ . '/../../models/City.php';
require_once __DIR__ . '/../../models/History.php';

use PrestaShop\Module\Weather\controllers\front\ViewController;
use PrestaShop\Module\Weather\controllers\front\ErrorController;

/**
 * Controller for the main page: Listing all the cities
 */
class CitiesListController extends ViewController {

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
	 * @return void
	 */
	public function initContent() {
		parent::initContent();
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
			ErrorController::init($e->getMessage());
			exit;
		} catch (\InvalidArgumentException $e) {
			ErrorController::init($e->getMessage());
			exit;
		}
		$history = self::getData($lastCity, $apiName);
		if (empty($this->context->smarty)) {
			return;
		}
		error_log('Rendering CitiesListController with method: ' . $this->methodName);
		$this->context->smarty->assign(array(
			'method'   => $this->methodName,
			"city"     => $lastCity,
			"history"  => $history,
			"cities"   => $cities,
			"homeLink" => $this->context->link->getPageLink('index'),
		));

		$this->setTemplate('module:weather/views/templates/front/citiesList.tpl');

		// $context = \ContextCore::getContext();
		// $context->smarty->assign(array(
		// 	'method'   => $this->methodName,
		// 	"city"     => $lastCity,
		// 	"history"  => $history,
		// 	"cities"   => $cities,
		// 	"homeLink" => $context->link->getPageLink('index'),
		// ));
		// $context->smarty->display('front/citiesList.tpl');
	}
}
