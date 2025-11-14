<?php
// main.php
// http://localhost/prestashop/index.php?fc=module&module=weather&controller=main
// http://localhost/prestashop/en/module/weather/main

// require_once __DIR__ . '/autoloader.php';

use PrestaShop\Module\Weather\controllers\front\MainController;

// require_once __DIR__ . '/MainController.php';

class weatherMainModuleFrontController extends ModuleFrontController {

    public function initContent() {
        $this->display_column_left = false;   // Hide left column

        parent::initContent();

        MainController::index();
    }
}
    