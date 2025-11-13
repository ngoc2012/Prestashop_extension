<?php
// mycontroller.php
// http://localhost/prestashop/en/?fc=module&module=weather&controller=mycontroller
// http://localhost/prestashop/en/module/weather/mycontroller
// http://localhost/prestashop/module/weather/mycontroller
// http://localhost/prestashop/en/module/weather/mycontroller
// http://localhost/prestashop/index.php?fc=module&module=weather&controller=mycontroller&id_lang=1

class WeatherMycontrollerModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        // You can assign variables to the Smarty template
        $this->context->smarty->assign(array(
            'my_message' => 'Hello from mymodule controller!',
            'customer_name' => $this->context->customer->firstname,
        ));

        // Load a template from views/templates/front/
        $this->setTemplate('mytemplate.tpl');
    }
}
    