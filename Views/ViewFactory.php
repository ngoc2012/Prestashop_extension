<?php
namespace PrestaShop\Module\Weather\Views;

use PrestaShop\Module\Weather\Views\SmartyView;
use PrestaShop\Module\Weather\Views\RainView;

/**
 * Factory class for all types of renderer
 */
class ViewFactory {


    // ======================
    // === Public Methods ===
    // ======================

    /**
     * Create a view renderer based on the specified type.
     *
     * @param string $type The type of renderer ('smarty' or 'raintpl')
     * @return ViewInterface The corresponding view renderer instance
     */
    public static function create($type = 'smarty') {
        switch (strtolower($type)) {
            case 'smarty':
                return new SmartyView();
            case 'raintpl':
                return new RainView();
            default:
                error_log("Unknown view type: $type. Defaulting to SmartyView.");
                return new SmartyView();
        }
    }
}
