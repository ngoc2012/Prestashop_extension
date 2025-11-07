<?php
namespace PrestaShop\Module\Weather\Controllers;

use ConfigurationCore;
use PrestaShop\Module\Weather\Controllers\AbstractViewController;

/**
 * Controller for handling errors pages
 */
class ErrorController extends AbstractViewController {


    // =========================
    // === Public Methods ======
    // =========================
    
    /**
     * Display an error message.
     * @param string $message
     * @return void
     */
    public function init($message = null) {
        $this->getView()->render('error.tpl', ['base_url' => ConfigurationCore::get('BASE_URL'), 'errorMessage' => $message]);
    }
}
