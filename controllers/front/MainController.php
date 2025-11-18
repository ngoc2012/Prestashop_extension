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
	public static function index($methodName = 'post') {
		if ($methodName == "get") {
			$method = $_GET;
		} else {
			$method = $_POST;
		}
		if (isset($method["name"])) {
			if (isset($method['id_city'])) {
				$city = new \City(intval($method['id_city']));
				if (!$city || $city->name !== trim($method['name'])) {
					(new ErrorController())->init("City ID and name do not match.");
					exit;
				}
			} else {
				try {
					$city = \City::findByName($method['name']);
				} catch (PrestaShopException $e) {
					$city = new \City();
					$city->name = trim($method['name']);
					$city->add();
				}
			}
			$controller = new CityWeatherController($city, trim($method['api']));
		} else {
			$controller = new CitiesListController($methodName);
		}
		$controller->initContent();
	}
}
