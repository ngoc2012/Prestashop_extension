<?php
require_once __DIR__ . '/autoloader.php';

use PrestaShop\Module\Weather\MyControllers\MainController;

/**
 * Main entry point function
 */
function main_index() {
	MainController::index();
}