<?php
namespace PrestaShop\Module\Weather\Services\API;

require_once __DIR__ . "/../../Models/City.php";

use PrestaShop\Module\Weather\Services\API\AbstractWeatherApi;
use RuntimeException;
use ConfigurationCore;

/**
 * OpenWeatherApi class to interact with the OpenWeather API
 */
class OpenWeatherApi extends AbstractWeatherApi {


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
        parent::__construct();
        $this->apiName = "OpenWeatherApi";
        $this->apiKey  = $apiKey ?: ConfigurationCore::get('OPENWEATHER_API_KEY');
        $this->baseUrl = $baseUrl ?: ConfigurationCore::get('OPENWEATHER_BASE_URL');
    }


    // ======================
    // === Public methods ===
    // ======================
    
    /**
     * Get weather data for a specified city.
     * @param \City $city
     * @return [float, float]
     * @throws RuntimeException
     */
    public function fetchWeather($city) {
        $cityNameEscaped = $city->encodeCityName();
        $url = $this->getUrl($cityNameEscaped);
        $response = file_get_contents($url, false, $this->context);
        if (!$response) {
            throw new RuntimeException("Failed to fetch weather data from OpenWeather API.");
        }
        // {"cod":401, "message": "Invalid API key. Please see https://openweathermap.org/faq#error401 for more info."}
        // {"cod":"404","message":"city not found"}
        $data = json_decode($response, true);
        if (isset($data["cod"]) && $data["cod"] !== 200) {
            throw new RuntimeException("OpenWeather API error: " . $data["cod"] . " - " . $data["message"]);
        }
        $temperature = $data['main']['temp'];
        $humidity = $data['main']['humidity'];
        return [$temperature, $humidity];
    }


    // =======================
    // === Private methods ===
    // =======================

    /**
     * Get the API request URL for a specific city.
     * @param string $cityNameEscaped
     * @return string The complete API request URL.
     */
    private function getUrl($cityNameEscaped) {
        return $this->baseUrl . "?q={$cityNameEscaped}&units=metric&lang=en&appid={$this->apiKey}";
    }
}
