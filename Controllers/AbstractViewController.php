<?php
namespace PrestaShop\Module\Weather\Controllers;

use PrestaShop\Module\Weather\Services\WeatherService;
use PrestaShop\Module\Weather\Models\City;
use PrestaShop\Module\Weather\Models\History;
use PDOException;
use RuntimeException;
use InvalidArgumentException;
use Exception;

/**
 * Base controller class to handle view rendering
 */
abstract class AbstractViewController {

    
    // ========================
    // === Abstract Methods ===
    // ========================
    
    /**
     * Abstract init method to be implemented by subclasses
     */
    abstract public function init();


    // =========================
    // === Protected Methods ===
    // =========================

    /**
     * Get weather data for a city using specified API.
     * @param City $city
     * @param string $apiName
     * @return History
     */
    protected static function getData($city, $apiName) {
        try {
            $lastHistory = WeatherService::getData($city, $apiName);
            return $lastHistory;
        } catch (RuntimeException $e) {
            ErrorController::init($e->getMessage());
            exit;
        } catch (InvalidArgumentException $e) {
            ErrorController::init($e->getMessage());
            exit;
        } catch (PDOException $e) {
            ErrorController::init($e->getMessage());
            exit;
        } catch (Exception $e) { // catch anything else
            ErrorController::init('Unexpected error: ' . $e->getMessage());
            exit;
        }
    }
    
}
