<?php

require_once __DIR__ . '/main.php';
require_once __DIR__ . '/config/AppConfig.php';

if (!defined('_PS_VERSION_')) {
	exit;
}

class Weather extends Module {
	protected $config_form = false;

	public function __construct() {
		$this->name = 'weather';
		$this->tab = 'others';
		$this->version = '1.0.0';
		$this->author = 'Minh Ngoc Nguyen';
		$this->controllers = array('example');
		$this->need_instance = 0; //Use only if you need dynamic info (like version checks, custom status display, etc.)

		/**
		* Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
		*/
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Weather');
		$this->description = $this->l('Display weather of some cities in the world');

		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => '9.0');
	}

	/**
	 * Don't forget to create update methods if needed:
	 * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
	 */
	public function install() {

		include dirname(__FILE__).'/sql/install.php';

		ConfigurationCore::updateValue('OPENWEATHER_API_KEY', AppConfig::OPENWEATHER_API_KEY);
		ConfigurationCore::updateValue('OPENWEATHER_BASE_URL', AppConfig::OPENWEATHER_BASE_URL);
		ConfigurationCore::updateValue('FREEWEATHER_API_KEY', AppConfig::FREEWEATHER_API_KEY);
		ConfigurationCore::updateValue('FREEWEATHER_BASE_URL', AppConfig::FREEWEATHER_BASE_URL);
		ConfigurationCore::updateValue('BASE_URL', AppConfig::BASE_URL);

		return parent::install() &&
		$this->installTab() &&
		$this->registerHook('header') &&
		$this->registerHook('displayBackOfficeHeader') &&
		$this->registerHook('displayHome');
	}

	private function installTab() {
		$tab = new Tab();
		$tab->class_name = 'AdminWeather';
		$tab->module = $this->name;
		$tab->id_parent = (int)Tab::getIdFromClassName('AdminParentModules'); // under Modules menu
		$tab->name = array();
		// var_dump($tab);
		foreach (Language::getLanguages(true) as $lang) {
			$tab->name[$lang['id_lang']] = 'Weather Management';
		}

		return $tab->add();
	}

	public function uninstall() {
		//Configuration::deleteByName('WEATHER_LIVE_MODE');

		include dirname(__FILE__).'/sql/uninstall.php';

		return parent::uninstall() && $this->uninstallTab();
	}

	private function uninstallTab() {
		$id_tab = Tab::getIdFromClassName('AdminWeather');
		if ($id_tab) {
			$tab = new Tab($id_tab);
			return $tab->delete();
		}
		return true;
	}

	/**
	 * Load the configuration form
	 */
	public function getContent() {
		/**
		* If values have been submitted in the form, process.
		*/
		if (((bool)Tools::isSubmit('submitWeatherModule')) == true) {
			$this->postProcess();
		}

		$this->context->smarty->assign('module_dir', $this->_path);

		$output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

		return $output.$this->renderForm();
	}

	/**
	 * Create the form that will be displayed in the configuration of your module.
	 */
	protected function renderForm() {
		$helper = new HelperForm();

		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$helper->module = $this;
		$helper->default_form_language = $this->context->language->id;
		$helper->allow_employee_form_lang = ConfigurationCore::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitWeatherModule';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
		.'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');

		$helper->tpl_vars = array(
		'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
		'languages' => $this->context->controller->getLanguages(),
		'id_language' => $this->context->language->id,
		);

		return $helper->generateForm(array($this->getConfigForm()));
	}

	/**
	 * Create the structure of your form.
	 */
	protected function getConfigForm() {
		return array(
		'form' => array(
		'legend' => array(
		'title' => $this->l('Settings'),
		'icon' => 'icon-cogs',
		),
		'input' => array(
					array(
						'col' => 6,
						'type' => 'text',
						'name' => 'OPENWEATHER_API_KEY',
						'label' => $this->l('OpenWeather API Key'),
		),
					array(
						'col' => 6,
						'type' => 'text',
						'name' => 'OPENWEATHER_BASE_URL',
						'label' => $this->l('OpenWeather Base URL'),
		),
					array(
						'col' => 6,
						'type' => 'text',
						'name' => 'FREEWEATHER_API_KEY',
						'label' => $this->l('FreeWeather API Key'),
		),
					array(
						'col' => 6,
						'type' => 'text',
						'name' => 'FREEWEATHER_BASE_URL',
						'label' => $this->l('FreeWeather Base URL'),
		),
					array(
						'col' => 6,
						'type' => 'text',
						'name' => 'BASE_URL',
						'label' => $this->l('Base URL'),
		),
					array(
						'col' => 3,
						'type' => 'text',
						'prefix' => '<i class="icon icon-envelope"></i>',
						'desc' => $this->l('Enter a valid email address'),
						'name' => 'WEATHER_ACCOUNT_EMAIL',
						'label' => $this->l('Email'),
		),
					array(
						'type' => 'password',
						'name' => 'WEATHER_ACCOUNT_PASSWORD',
						'label' => $this->l('Password'),
		),
		),
		'submit' => array(
					'title' => $this->l('Save'),
		),
		),
		);
	}

	/**
	 * Set values for the inputs.
	 */
	protected function getConfigFormValues() {
		return array(
		'WEATHER_ACCOUNT_EMAIL' => ConfigurationCore::get('WEATHER_ACCOUNT_EMAIL', 'contact@prestashop.com'),
		'WEATHER_ACCOUNT_PASSWORD' => ConfigurationCore::get('WEATHER_ACCOUNT_PASSWORD', null),
		'OPENWEATHER_API_KEY'=> ConfigurationCore::get('OPENWEATHER_API_KEY', null),
		'OPENWEATHER_BASE_URL'=> ConfigurationCore::get('OPENWEATHER_BASE_URL', null),
		'FREEWEATHER_API_KEY'=> ConfigurationCore::get('FREEWEATHER_API_KEY', null),
		'FREEWEATHER_BASE_URL'=> ConfigurationCore::get('FREEWEATHER_BASE_URL', null),
		'BASE_URL'=> ConfigurationCore::get('BASE_URL', null),
		);
	}

	/**
	 * Save form data.
	 */
	protected function postProcess() {
		$form_values = $this->getConfigFormValues();

		foreach (array_keys($form_values) as $key) {
			ConfigurationCore::updateValue($key, Tools::getValue($key));
		}
	}

	/**
	 * Add the CSS & JavaScript files you want to be loaded in the BO.
	 */
	public function hookDisplayBackOfficeHeader() {
		if (Tools::getValue('configure') == $this->name) {
			$this->context->controller->addJS($this->_path.'views/js/back.js');
			$this->context->controller->addCSS($this->_path.'views/css/back.css');
		}
	}

	/**
	 * Add the CSS & JavaScript files you want to be added on the FO.
	 */
	public function hookHeader() {
		$this->context->controller->addJS($this->_path.'/views/js/front.js');
		$this->context->controller->addCSS($this->_path.'/views/css/front.css');
	}

	public function hookDisplayHome() {

		$tplPath = _PS_MODULE_DIR_ . 'weather/views/templates/';
		$this->context->smarty->addTemplateDir($tplPath);
		mainIndex();
	}
}
