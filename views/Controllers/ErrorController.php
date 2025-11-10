<?php
namespace PrestaShop\Module\Weather\Controllers;

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
        $container = $this->getView()->fetch('error.tpl', ['errorMessage' => $message]);
        $this->getView()->renderMain('index.tpl', $container);
    }
}
