<?php
namespace PrestaShop\Module\Weather\Services\API;

use PrestaShop\Module\Weather\Models\City;
use PrestaShop\Module\Weather\Services\API\AbstractWeatherApi;
use RuntimeException;
use ConfigurationCore;

/**
 * FreeWeatherApi class to interact with the FreeWeather API
 */
class FreeWeatherApi extends AbstractWeatherApi {


    // ===================
    // === Constructor ===
    // ===================

    /**
     * Constructor allows overriding the API key and base URL.
     * 
     * @param string|null $apiKey
     * @param string|null $baseUrl
     */
    public function __construct($apiKey = null, $baseUrl = null) {
        $this->apiName = "FreeWeatherApi";
        $this->apiKey  = $apiKey ?: ConfigurationCore::get('FREEWEATHER_API_KEY');
        $this->baseUrl = $baseUrl ?: ConfigurationCore::get('FREEWEATHER_BASE_URL');
    }

    
    // ======================
    // === Public methods ===
    // ======================

    /**
     * Get weather data for a specified city.
     * @param City $city
     * @return [float, float]
     * @throws RuntimeException
     */
    public function fetchWeather($city) {
        $cityNameEscaped = $this->encodeCityName($city->getName());
        $url = $this->getUrl($cityNameEscaped);
        $response = file_get_contents($url);
        if (!$response) {
            throw new RuntimeException("Failed to fetch weather data from FreeWeather API.");
        }
        $data = json_decode($response, true);
        $temperature = $data['current']['temp_c'];
        $humidity = $data['current']['humidity'];
        return [$temperature, $humidity];
    }


    // =======================
    // === Private methods ===
    // =======================

    /**
     * Construct the full API URL for fetching weather data.
     *
     * @param string $cityNameEscaped The URL-encoded city name.
     * @return string The complete API URL.
     */
    private function getUrl($cityNameEscaped) {
        return $this->baseUrl . "?key={$this->apiKey}&q={$cityNameEscaped}&aqi=no";
    }
}