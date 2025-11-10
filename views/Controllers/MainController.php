<?php
namespace PrestaShop\Module\Weather\Controllers;

use PrestaShop\Module\Weather\Models\City;
use PrestaShop\Module\Weather\Controllers\CityWeatherController;
use PrestaShop\Module\Weather\Controllers\CitiesListController;
use RuntimeException; 

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
            $city = City::transformDataToCity($_GET);
            if (isset($_GET['id'])) {
                $city_found = City::findById(intval($_GET['id']));
                if ($city_found->getName() !== $city->getName()) {
                    (new ErrorController('smarty'))->init("City ID and name do not match.");
                    exit;
                }
            }
            $controller = new CityWeatherController('smarty', $city, trim($_GET['api']));
        } else {
            $controller = new CitiesListController('raintpl');
        }
        try {
            $controller->init();
        } catch (RuntimeException $e) {
            (new ErrorController('smarty'))->init($e->getMessage());
            exit;
        }
    }   
}
