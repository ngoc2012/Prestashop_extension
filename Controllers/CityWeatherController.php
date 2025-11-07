<?php
namespace PrestaShop\Module\Weather\Controllers;

use ConfigurationCore;
use PrestaShop\Module\Weather\Controllers\AbstractViewController;
use PrestaShop\Module\Weather\Services\WeatherService;
use PrestaShop\Module\Weather\Models\City;
use PrestaShopDatabaseException;
use RuntimeException;
use InvalidArgumentException;
use Exception;

/**
 * Controller for the city weather page
 */
class CityWeatherController extends AbstractViewController {


    // =================
    // === Variables ===
    // =================

    /* @var City */
    private $city;
    /* @var string */
    private $apiName;


    // ===================
    // === Constructor ===
    // ===================
    
    /**
     * Constructor for the CityWeatherController.
     * @param string $viewType
     * @param City $city
     * @param string $apiName
     */
    public function __construct($viewType, City $city, $apiName) {
        parent::__construct($viewType);
        $this->city = $city;
        $this->apiName = $apiName;
    }

    
    // ======================
    // === Public Methods ===
    // ======================

    /**
     * Get the weather data for a specific city and display it.
     * 
     * @return void
     */
    public function init() {
        try {
            WeatherService::getData($this->city, $this->apiName);
            $lastHistory = $this->city->getLastHistory();
        } catch (RuntimeException $e) {
            (new ErrorController('smarty'))->init($e->getMessage());
            exit;
        } catch (InvalidArgumentException $e) {
            (new ErrorController('smarty'))->init($e->getMessage());
            exit;
        } catch (PrestaShopDatabaseException $e) {
            (new ErrorController('smarty'))->init($e->getMessage());
            exit;
        } catch (Exception $e) { // catch anything else
            (new ErrorController('smarty'))->init('Unexpected error: ' . $e->getMessage());
            exit;
        }

        $this->getView()->render('city_weather.tpl', ['base_url' => ConfigurationCore::get('BASE_URL'), 'city' => $this->city, 'lastHistory' => $lastHistory]);
    }
}