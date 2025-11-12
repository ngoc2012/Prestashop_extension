<?php
namespace PrestaShop\Module\Weather\Controllers;

require_once __DIR__ . '/../Models/City.php';
require_once __DIR__ . '/../Models/History.php';

use PrestaShop\Module\Weather\Controllers\CityWeatherController;
use PrestaShop\Module\Weather\Controllers\CitiesListController;
use RuntimeException;
use PrestaShopExceptionCore;

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
                } catch (PrestaShopExceptionCore $e) {
                    ErrorController::init($e->getMessage());
                    exit;
                }
            }
            $controller = new CityWeatherController($city, trim($_GET['api']));
        } else {
            $controller = new CitiesListController();
        }
        try {
            $controller->init();
        } catch (RuntimeException $e) {
            ErrorController::init($e->getMessage());
            exit;
        }
    }   
}
