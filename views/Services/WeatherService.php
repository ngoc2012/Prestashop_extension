<?php
namespace App\Services;

use App\Models\City;
use App\Models\History;
use App\Services\API\FreeWeatherApi;
use App\Services\API\OpenWeatherApi;
use InvalidArgumentException;
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
     * @return History
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
        if (!$city->getId()) {
            try {
                $cityFound = City::findByName($city->getName());
                $city->setId($cityFound->getId());
            } catch (InvalidArgumentException $e) {
                $newCity = City::save($city->getName());
                $city->setId($newCity->getId());
            }
        }
        $history = History::transformDataToHistory([
            "cityId" => $city->getId(),
            "api" => $api->getApiName(),
            "temperature" => $temperature,
            "humidity" => $humidity
        ]);
        History::save($history);
        return $history;
    }
}
