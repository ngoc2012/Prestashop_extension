<?php
namespace PrestaShop\Module\Weather\Services\API;

use PrestaShop\Module\Weather\Models\City;

/**
 * Base class for all WeatherApi type
 */
abstract class AbstractWeatherApi { // implements WeatherApiInterface {


    // =================
    // === Variables ===
    // =================

    /* @var string */
    protected $apiKey;
    /* @var string */
    protected $baseUrl;
    /* @var string */
    protected $apiName;

    
    // ======================
    // === Public Methods ===
    // ======================

    /**
     * Fetch weather data for a given city.
     *
     * @param City $city The City object.
     */
    abstract public function fetchWeather($city);


    // =========================
    // === Protected Methods ===
    // =========================
    /**
     * Encode the city name for URL usage.
     *
     * @param string $cityName The name of the city.
     * @return string The URL-encoded city name.
     */
    protected function encodeCityName($cityName) {
        return urlencode($cityName);
    }


}

