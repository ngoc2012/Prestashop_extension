<?php
namespace PrestaShop\Module\Weather\controllers\front;

require_once __DIR__ . '/../../models/City.php';
require_once __DIR__ . '/../../models/History.php';

use PrestaShop\Module\Weather\controllers\front\CityWeatherController;
use PrestaShop\Module\Weather\controllers\front\CitiesListController;
use PrestaShopException;

/**
* Main page: entry point for all pages
*/
class MainController {
	
	
	// =========================
	// === Public Methods ======
	// =========================
	
	/**
	* Main entry point of the application.
	*/
	public static function index() {
		if (isset($_GET["name"])) {
			if (isset($_GET['id_city'])) {
				$city = new \City(intval($_GET['id_city']));
				if (!$city || $city->name !== trim($_GET['name'])) {
					ErrorController::init("City ID and name do not match.");
					exit;
				}
			} else {
				try {
					$city = \City::findByName($_GET['name']);
				} catch (PrestaShopException $e) {
					$city = new \City();
					$city->name = trim($_GET['name']);
					$city->add();
				}
			}
			$controller = new CityWeatherController($city, trim($_GET['api']));
		} else {
			$controller = new CitiesListController();
		}
		$controller->init();
	}   
}
