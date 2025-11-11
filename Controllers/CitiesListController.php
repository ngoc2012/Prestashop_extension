<?php
namespace PrestaShop\Module\Weather\Controllers;

use ContextCore;
use PrestaShop\Module\Weather\Controllers\AbstractViewController;
use PrestaShop\Module\Weather\Models\City;
use PrestaShop\Module\Weather\Models\History;
use PDOException;
use InvalidArgumentException;

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
        try {
            $cities = City::findAll();
            $lastHistory = History::findLast();
            if ($lastHistory) {
                $lastCity = new City($lastHistory->cityId);
                $apiName = $lastHistory->api;
            } else {
                $lastCity = $cities[0];
                $apiName = "OpenWeatherApi";
            }
        } catch (PDOException $e) {
            ErrorController::init($e->getMessage());
            exit;
        } catch (InvalidArgumentException $e) {
            ErrorController::init($e->getMessage());
            exit;
        }
        // // Create a new city
        $city = new City();
        $city->name = "Parisdfsdfas";
        $city->visitedAt = date('Y-m-d H:i:s');
        $city->add(); // -> Crash

        var_dump("end game" . $cities);
        // // Load a city by ID
        // $city = new City(1);
        // var_dump($city);
        // var_dump($lastCity);
        // var_dump($apiName);
        $history = self::getData($lastCity, $apiName);
        // var_dump($history);
        $context = ContextCore::getContext();
        // $context->smarty->assign("city", $lastCity);
        // $context->smarty->assign("history", $history);
        // $context->smarty->assign("cities", $cities);
        $context->smarty->display("citiesList.tpl");
    }
}
