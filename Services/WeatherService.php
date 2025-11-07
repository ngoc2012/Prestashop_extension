<?php
namespace PrestaShop\Module\Weather\Services;

use PrestaShop\Module\Weather\Models\City;
use PrestaShop\Module\Weather\Models\History;
use PrestaShop\Module\Weather\Services\API\FreeWeatherApi;
use PrestaShop\Module\Weather\Services\API\OpenWeatherApi;

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
     * @param City $city The City object.
     * @param string|null $apiName The name of the API to use (optional).
     * @return void
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
        $history = History::transformDataToHistory([
            "cityId" => $city->getId(),
            "api" => $apiName,
            "temperature" => $temperature,
            "humidity" => $humidity
        ]);
        History::save($history);
    }
}
