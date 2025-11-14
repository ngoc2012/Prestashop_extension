<?php
// example.php
// http://localhost/prestashop/index.php?fc=module&module=weather&controller=example


class weatherExampleModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        $this->display_column_left = false;   // Hide left column

        parent::initContent();

        // You can assign variables to the Smarty template
        $this->context->smarty->assign(array(
            'my_message' => 'Hello from my module controller dsfsadf!',
            'customer_name' => $this->context->customer->firstname,
        ));

        // Load a template from views/templates/front/
        $this->setTemplate('mytemplate.tpl');
    }
}
    