<?php

/**
 * Main controller for handling weather module requests
 */
class WeatherMainModuleFrontController extends \ModuleFrontController {

	public function initContent($methodName = 'post') {
		// $this->display_column_left = false;   // Hide left column
		$this->context = \ContextCore::getContext();
		parent::initContent();

		if ($methodName == "get") {
			$method = $_GET;
		} else {
			$method = $_POST;
		}
		if (isset($method["name"])) {
			if (isset($method['id_city'])) {
				$city = new \City(intval($method['id_city']));
				if (!$city || $city->name !== trim($method['name'])) {
					(new WeatherErrorModuleFrontController())->initContent("City ID and name do not match.");
					exit;
				}
			} else {
				try {
					$city = \City::findByName($method['name']);
				} catch (\PrestaShopException $e) {
					$city = new \City();
					$city->name = trim($method['name']);
					$city->add();
				}
			}
			$controller = new \WeatherCityWeatherModuleFrontController($city, trim($method['api']));
		} else {
			$controller = new \WeatherCitiesListModuleFrontController($methodName);
		}
		$controller->initContent();
	}
}
