<?php
namespace PrestaShop\Module\Weather\Controllers;

use PrestaShop\Module\Weather\Views\ViewFactory;
use PrestaShop\Module\Weather\Views\ViewInterface;
use PrestaShop\Module\Weather\Services\WeatherService;
use PrestaShop\Module\Weather\Models\City;
use PrestaShop\Module\Weather\Models\History;
use PDOException;
use RuntimeException;
use InvalidArgumentException;
use Exception;

/**
 * Base controller class to handle view rendering
 */
abstract class AbstractViewController {


    // =================
    // === Variables ===
    // =================

    /* @var ViewInterface renderer instance */
    private $view;


    // ===================
    // === Constructor ===
    // ===================

    /**
     * Constructor:
     * - Get the renderer instance from ViewFactory
     * @param string $viewType
     * @return void
     */
    public function __construct($viewType = 'smarty') {
        $this->view = ViewFactory::create($viewType);
    }


    // ========================
    // === Abstract Methods ===
    // ========================
    
    /**
     * Abstract init method to be implemented by subclasses
     */
    abstract public function init();


    // =========================
    // === Public Methods ======
    // =========================

    /**
     * View getter
     * @return ViewInterface
     */
    public function getView() {
        return $this->view;
    }


    // =========================
    // === Protected Methods ===
    // =========================

    /**
     * Get weather data for a city using specified API.
     * @param City $city
     * @param string $apiName
     * @return History
     */
    protected function getData($city, $apiName) {
        try {
            $lastHistory = WeatherService::getData($city, $apiName);
            return $lastHistory;
        } catch (RuntimeException $e) {
            (new ErrorController('smarty'))->init($e->getMessage());
            exit;
        } catch (InvalidArgumentException $e) {
            (new ErrorController('smarty'))->init($e->getMessage());
            exit;
        } catch (PDOException $e) {
            (new ErrorController('smarty'))->init($e->getMessage());
            exit;
        } catch (Exception $e) { // catch anything else
            (new ErrorController('smarty'))->init('Unexpected error: ' . $e->getMessage());
            exit;
        }
    }
    
}
