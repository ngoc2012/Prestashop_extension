<?php
namespace PrestaShop\Module\Weather\Controllers;

require_once __DIR__ . '/../Models/City.php';
require_once __DIR__ . '/../Models/History.php';

use ContextCore;
use PrestaShop\Module\Weather\Controllers\AbstractViewController;
use PDOException;
use InvalidArgumentException;
use PrestaShopException;

/**
 * Controller for the main page: Listing all the cities
 */
class CitiesListController extends AbstractViewController {

    
    // =========================
    // === Public Methods ======
    // =========================
    
    /**
     * Display the list of cities.
     * @return void
     */
    public function init() {
        $apiName = 'OpenWeatherMap';
        try {
            $cities = \City::findLastVisitedCities(10);
            if (count($cities) === 0) {
                $lastCity = new \City();
                $lastCity->name = 'Paris';
                $lastCity->add();
            } else {
                try {
                    $lastHistory = \History::findLast();
                    $apiName = $lastHistory->api;
                    $lastCityId = $lastHistory->cityId;
                } catch (PrestaShopException $e) {
                    $lastCityId = $cities[0]->id_city;
                }
                $lastCity = new \City($lastCityId);
            }
        } catch (PDOException $e) {
            ErrorController::init($e->getMessage());
            exit;
        } catch (InvalidArgumentException $e) {
            ErrorController::init($e->getMessage());
            exit;
        }
        $history = self::getData($lastCity, $apiName);
        $context = ContextCore::getContext();
        $context->smarty->assign("city", $lastCity);
        $context->smarty->assign("history", $history);
        $context->smarty->assign("cities", $cities);
        $context->smarty->display("citiesList.tpl");
    }
}
