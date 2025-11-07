<?php
namespace PrestaShop\Module\Weather\Views;

use PrestaShop\Module\Weather\Views\ViewInterface;
use Smarty;
use Exception;
use RuntimeException;

/**
 * Renderer class using Smarty
 */
class SmartyView implements ViewInterface {


    // =================
    // === Variables ===
    // =================

    /* @var Smarty instance */
    private $smarty;


    // ====================
    // === Constructors ===
    // ====================

    /**
     * Constructor and Smarty configuration
     */
    public function __construct() {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../views/templates/');
        $this->smarty->setCompileDir(__DIR__ . '/../views/templates_c/');
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
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        try {
            $this->smarty->display($template);
        } catch (Exception $e) {
            throw new RuntimeException("Failed to render template: " . $e->getMessage());
        }
    }
}
