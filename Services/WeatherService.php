<?php
namespace PrestaShop\Module\Weather\Services;

require_once __DIR__ . '/../Models/City.php';
require_once __DIR__ . '/../Models/History.php';

use PrestaShop\Module\Weather\Services\API\FreeWeatherApi;
use PrestaShop\Module\Weather\Services\API\OpenWeatherApi;
// use InvalidArgumentException;

/**
 * WeatherService class to fetch weather data
 */
class WeatherService {


    // ======================
    // === Public methods ===
    // ======================

    /**
     * Fetch weather metrics for a given city using the specified API.
     *
     * @param \City $city The City object.
     * @param string|null $apiName The name of the API to use (optional).
     * @return \History
     */
    public static function getData($city, $apiName = null) {
        switch ($apiName) {
            case 'FreeWeatherApi':
                $api = new FreeWeatherApi();
                break;
            default:
                $api = new OpenWeatherApi();
                break;
        }
        list($temperature, $humidity) = $api->fetchWeather($city);
        $history = new \History();
        var_dump($city);
        error_log("**********city id: " . $city->id_city);
        $history->cityId = $city->id_city;
        $history->api = $api->getApiName();
        $history->temperature = $temperature;
        $history->humidity = $humidity;
        $history->createdAt = date('Y-m-d H:i:s');
        $history->add();
        return $history;
    }
}
