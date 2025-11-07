<?php
namespace PrestaShop\Module\Weather\Views;

require_once __DIR__ . '/../libs/rain.tpl.class.php';

use PrestaShop\Module\Weather\Views\ViewInterface;
use RainTPL;
use Exception;
use RuntimeException;
use Smarty;

/**
 * Renderer class using RainTPL
 */
class RainView implements ViewInterface {


    // =================
    // === Variables ===
    // =================

    /* @var RainTPL instance */
    private $tpl;


    // ====================
    // === Constructors ===
    // ====================

    /**
     * Constructor and RainTPL configuration
     */
    public function __construct() {

        RainTPL::configure("base_url", '/');
        RainTPL::configure("tpl_dir", __DIR__ . "/../views/templates/");
        RainTPL::configure("cache_dir", __DIR__ . "/../views/templates_c/");
        RainTPL::configure("tpl_ext", "tpl");

        $this->tpl = new RainTPL;
    }


    // ======================
    // === Public methods ===
    // ======================
    
    /**
     * Render a template directly to output.
     *
     * @param string $template Template file name
     * @param array $data Associative array to assign
     * @return void
     */
    public function render($template, array $data = []) {
        $fileNameRaintpl = pathinfo($template, PATHINFO_FILENAME) . '.raintpl';
        foreach ($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
        $this->tpl->assign('smarty', new Smarty());

        try {
            $this->tpl->draw($fileNameRaintpl, false);
        } catch (Exception $e) {
            throw new RuntimeException("Failed to render template " . $fileNameRaintpl . ": " . $e->getMessage());
        }
    }
}
