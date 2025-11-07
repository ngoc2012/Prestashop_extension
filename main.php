<?php
require_once __DIR__ . '/autoloader.php';

use PrestaShop\Module\Weather\Controllers\MainController;

function main_index() {
    MainController::index();
}