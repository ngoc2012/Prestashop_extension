<?php
/**
 * Weather Module for PrestaShop
 *
 *  @author    Minh Ngoc Nguyen
 */


if (!defined('_PS_VERSION_')) {
	exit;
}

class Weather extends \Certideal\PrestashopHelpers\CertidealAbstractModule {


	// ===================
	// === Constructor ===
	// ===================

	public function __construct() {
		include_once dirname(__FILE__).'/config/AppConfig.php';

		ConfigurationCore::updateValue('OPENWEATHER_API_KEY', AppConfig::OPENWEATHER_API_KEY);
		ConfigurationCore::updateValue('OPENWEATHER_BASE_URL', AppConfig::OPENWEATHER_BASE_URL);
		ConfigurationCore::updateValue('OPENWEATHER_URI', AppConfig::OPENWEATHER_URI);
		ConfigurationCore::updateValue('FREEWEATHER_API_KEY', AppConfig::FREEWEATHER_API_KEY);
		ConfigurationCore::updateValue('FREEWEATHER_BASE_URL', AppConfig::FREEWEATHER_BASE_URL);
		ConfigurationCore::updateValue('FREEWEATHER_URI', AppConfig::FREEWEATHER_URI);

		parent::__construct();
	}


	// ====================
	// === Hook Methods ===
	// ====================

	public function hookDisplayHome() {
		require_once __DIR__.'/controllers/CitiesList.php';
		$weatherController = new CitiesList('post');
		$weatherController->initContent();
	}


	// ==========================
	// === Configuration Form ===
	// ==========================

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
						'name' => 'OPENWEATHER_URI',
						'label' => $this->l('OpenWeather URI'),
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
						'name' => 'FREEWEATHER_URI',
						'label' => $this->l('FreeWeather URI'),
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
			'OPENWEATHER_URI'=> ConfigurationCore::get('OPENWEATHER_URI', null),
			'FREEWEATHER_API_KEY'=> ConfigurationCore::get('FREEWEATHER_API_KEY', null),
			'FREEWEATHER_BASE_URL'=> ConfigurationCore::get('FREEWEATHER_BASE_URL', null),
			'FREEWEATHER_URI'=> ConfigurationCore::get('FREEWEATHER_URI', null),
		);
	}

	/**
	* Save form data.
	*/
	protected function postProcess() {
		$formValues = $this->getConfigFormValues();

		foreach (array_keys($formValues) as $key) {
			ConfigurationCore::updateValue($key, Tools::getValue($key));
		}
	}


	// ==================================
	// === Override Certideal Methods ===
	// ==================================

	/**
	 * {@inheritDoc}
	 * @see \Certideal\PrestashopHelpers\CertidealAbstractModule::getModuleTabs()
	 */
	protected function getModuleTabs() {
		return [
			[
				'name' => [1 => 'Weather Management'],
				'class_name' => 'AdminWeather',
				'id_parent' => (int)\Tab::getIdFromClassName('AdminParentModules'),
				'child_tab' => false,
				'active' => true,
			],
		];
	}

	/**
	 * {@inheritDoc}
	 * @see \Certideal\PrestashopHelpers\CertidealAbstractModule::getModuleHooks()
	 */
	protected function getModuleHooks() {
		return [
			'displayHome'
		];
	}


	// ==================================
	// === Abstract Certideal Methods ===
	// ==================================

	/**
	 * {@inheritDoc}
	 * @see CertidealAbstractModule::getNameOfModule()
	 */
	protected function getNameOfModule() {
		return "weather";
	}

	/**
	 * {@inheritDoc}
	 * @see CertidealAbstractModule::getModuleTabName()
	 */
	protected function getModuleTabName() {
		return "Weather Management";
	}

	/**
	 * {@inheritDoc}
	 * @see CertidealAbstractModule::getModuleVersion()
	 */
	protected function getModuleVersion() {
		return "1.0.0";
	}

	/**
	 * {@inheritDoc}
	 * @see CertidealAbstractModule::getDisplayName()
	 */
	protected function getDisplayName() {
		return $this->l("Weather");
	}
}
