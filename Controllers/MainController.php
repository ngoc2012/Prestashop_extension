<?php
namespace PrestaShop\Module\Weather\Controllers;

use PrestaShop\Module\Weather\Core\PostParameterException;
use PrestaShop\Module\Weather\Models\City;
use PrestaShop\Module\Weather\Controllers\CityWeatherController;
use PrestaShop\Module\Weather\Controllers\CityListController;
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
        if (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["api"])) {
            try {
                self::checkPostParameters();
            } catch (PostParameterException $e) {
                (new ErrorController('smarty'))->init($e->getMessage());
                exit;
            }
            $city = City::transformDataToCity($_POST);
            $controller = new CityWeatherController('smarty', $city, trim($_POST['api']));
        } else {
            $controller = new CityListController('raintpl');
        }
        try {
            $controller->init();
        } catch (RuntimeException $e) {
            (new ErrorController('smarty'))->init($e->getMessage());
            exit;
        }
    }


    // =======================
    // === Private Methods ===
    // =======================

    /**
     * Check required POST parameters
     */
    private static function checkPostParameters() {
        if (!isset($_POST['id'])) {
            throw new PostParameterException('Missing city ID.');
        }
        if (!isset($_POST['name'])) {
            throw new PostParameterException('Missing city data.');
        }
        if (!isset($_POST['api'])) {
            throw new PostParameterException('Missing API data.');
        }
        // Convert ID to integer
        $_POST['id'] = (int) $_POST['id'];
        if ($_POST['id'] <= 0) {
            throw new PostParameterException('Invalid City ID.');
        }
    }
}
