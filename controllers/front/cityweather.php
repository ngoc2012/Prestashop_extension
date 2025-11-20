<?php

// http://localhost/prestashop/index.php?fc=module&module=weather&controller=cityweather

require_once __DIR__ . '/../../services/WeatherService.php';
require_once __DIR__ . '/../ErrorController.php';

/**
* Controller for the city weather page
*/
class weatherCityWeatherModuleFrontController extends \ModuleFrontController {


	// =================
	// === Variables ===
	// =================

	public $display_column_left = false;  // hides left column
	public $display_column_right = false;  // hides right column
	/* @var City */
	private $city;
	/* @var string */
	private $apiName;


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
		$this->checkInput();
		try {
			WeatherService::getData($this->city, $this->apiName);
		} catch (\RuntimeException $e) {
			$histories = $this->city->getHistories();
			if (count($histories) == 0) {
				$this->city->delete();
			}
			ErrorController::initContent($e->getMessage());
			exit;
		}
		$histories = $this->city->getHistories();
		if (count($histories) == 0) {
			ErrorController::initContent('No history found for this city.');
			exit;
		}
		$this->context->smarty->assign(array(
			'histories' => $histories,
			'city' => $this->city,
			'history' => $histories[0],
			'homeLink' => $this->context->link->getPageLink('index'),
		));
		// $this->setTemplate(_PS_MODULE_DIR_ . 'weather/views/templates/front/cityweather.tpl');
		$this->setTemplate('cityweather.tpl');
	}

	private function checkInput() {
		$this->context = \ContextCore::getContext();

		$methodName = isset($_GET['method']) ? $_GET['method'] : 'post';

		if ($methodName == "get") {
			$method = $_GET;
		} else {
			$method = $_POST;
		}
		if (isset($method["name"])) {
			if (isset($method['id'])) {
				$this->city = new \City(intval($method['id']));
				if (!$this->city || $this->city->name !== trim($method['name'])) {
					ErrorController::initContent("City ID and name do not match.");
					exit;
				}
			} else {
				try {
					$this->city = \City::findByName($method['name']);
				} catch (\PrestaShopException $e) {
					$this->city = new \City();
					$this->city->name = trim($method['name']);
					$this->city->add();
				}
			}
			if (isset($method['api'])) {
				$this->apiName = trim($method['api']);
			} else {
				$this->apiName = "OpenWeatherApi";
			}
		} else {
			ErrorController::initContent("City name is required.");
			exit;
		}
	}
}
