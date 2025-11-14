<?php

class AdminWeatherController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true; // Enable PrestaShop 1.6 bootstrap styling

        parent::__construct();
    }

    public function initContent()
    {
        
    }
}
