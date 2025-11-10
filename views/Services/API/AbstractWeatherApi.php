<?php
namespace App\Services\API;

use App\Models\City;

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
    /** @var resource */
    protected $context;


    // ===================
    // === Constructor ===
    // ===================

    public function __construct()
    {
        $this->context = stream_context_create([
            'http' => [
                'ignore_errors' => true, // KEEP BODY even if HTTP 400/500
                'timeout' => 5,
            ],
        ]);
    }

    
    // ======================
    // === Public Methods ===
    // ======================

    public function getApiName() {
        return $this->apiName;
    }

    /**
     * Fetch weather data for a given city.
     *
     * @param City $city The City object.
     */
    abstract public function fetchWeather($city);

}

