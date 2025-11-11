<?php
namespace PrestaShop\Module\Weather\Services;

use PrestaShop\Module\Weather\Models\City;
use PrestaShop\Module\Weather\Models\History;
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
        // if (!$city->getId()) {
        //     try {
        //         $cityFound = City::findByName($city->getName());
        //         $city->setId($cityFound->id);
        //     } catch (InvalidArgumentException $e) {
        //         $newCity = City::save($city->getName());
        //         $city->setId($newCity->getId());
        //     }
        // }
        var_dump([$temperature, $humidity]);
        $history = History::transformDataToHistory([
            "cityId" => $city->id,
            "api" => $api->getApiName(),
            "temperature" => $temperature,
            "humidity" => $humidity
        ]);
        var_dump($history);
        History::save2Db($history);
        var_dump("Saved to DB");
        return $history;
    }
}
