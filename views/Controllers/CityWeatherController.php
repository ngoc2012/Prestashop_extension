<?php
namespace PrestaShop\Module\Weather\Controllers;

use PrestaShop\Module\Weather\Controllers\AbstractViewController;
use PrestaShop\Module\Weather\Models\City;

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
        $this->getData($this->city, $this->apiName);
        $histories = $this->city->getHistories();
        if (count($histories) == 0) {
            (new ErrorController('smarty'))->init('No weather history found for this city.');
            exit;
        }
        City::updateVisitedAt($this->city->id);
        $weatherPanel = $this->getView()->fetch('weatherPanel.tpl', ['city' => $this->city, 'history' => $histories[0]]);
        $container = $this->getView()->fetch('cityWeather.tpl', ['histories' => $histories, 'weatherPanel' => $weatherPanel]);
        $this->getView()->renderMain('index.tpl', $container);
    }
}