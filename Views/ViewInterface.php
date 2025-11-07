<?php
namespace PrestaShop\Module\Weather\Views;

/**
 * Interface for abstract methods of renderers
 */
interface ViewInterface
{
    // ======================
    // === Public Methods ===
    // ======================
    
    /**
     * Render a template directly to output.
     *
     * @param string $template Template file name
     * @param array $data Variables to assign
     * @return void
     */
    public function render($template, array $data = []);
}
