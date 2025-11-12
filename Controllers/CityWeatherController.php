<?php
namespace PrestaShop\Module\Weather\Controllers;

require_once __DIR__ . '/../Models/City.php';
require_once __DIR__ . '/../Models/History.php';

use PrestaShop\Module\Weather\Controllers\AbstractViewController;
use ContextCore;

/**
 * Controller for the city weather page
 */
class CityWeatherController extends AbstractViewController {


    // =================
    // === Variables ===
    // =================

    /* @var City */
    public $city;
    /* @var string */
    public $apiName;


    // ===================
    // === Constructor ===
    // ===================
    
    /**
     * Constructor for the CityWeatherController.
     * @param string $viewType
     * @param \City $city
     * @param string $apiName
     */
    public function __construct(\City $city, $apiName) {
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
        $this->getData($this->city, $this->apiName);
        $histories = $this->city->getHistories();
        if (count($histories) == 0) {
            ErrorController::init('No weather history found for this city.');
            exit;
        }
        $context = ContextCore::getContext();
        $context->smarty->assign('histories', $histories);
        $context->smarty->assign('city', $this->city);
        $context->smarty->assign('history', $histories[0]);
        $context->smarty->display('cityWeather.tpl');
    }
}