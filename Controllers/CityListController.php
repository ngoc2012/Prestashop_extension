<?php
namespace PrestaShop\Module\Weather\Controllers;

use ConfigurationCore;
use PrestaShop\Module\Weather\Controllers\AbstractViewController;
use PrestaShop\Module\Weather\Models\City;
use PrestaShopDatabaseException;
use Exception;
/**
 * Controller for the main page: Listing all the cities
 */
class CityListController extends AbstractViewController {

    
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
        } catch (PrestaShopDatabaseException $e) {
            (new ErrorController('smarty'))->init($e->getMessage());
            exit;
        } catch (Exception $e) {
            (new ErrorController('raintpl'))->init("Unknown error: " . $e->getMessage());
            exit;
        }

        $this->getView()->render('index.tpl', ['base_url' => ConfigurationCore::get('BASE_URL'), 'cities' => $cities]);
    }
}
