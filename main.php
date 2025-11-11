<?php
require_once __DIR__ . '/autoloader.php';

use PrestaShop\Module\Weather\Controllers\MainController;

/**
 * Main entry point function
 */
function main_index() {
    MainController::index();
}