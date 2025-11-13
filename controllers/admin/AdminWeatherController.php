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
        parent::initContent();
        $this->context->smarty->assign(array(
            'my_message' => 'Hello, this is my custom admin page!'
        ));
        $this->setTemplate('my_template.tpl'); // Smarty template in views/templates/admin/
    }
}
