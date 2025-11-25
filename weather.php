<?php
/**
 * Weather Module for PrestaShop
 *
 *  @author    Minh Ngoc Nguyen
 */
if (!defined('_PS_VERSION_')) {
	exit;
}

require_once __DIR__.'/models/City.php';
require_once __DIR__.'/controllers/CitiesList.php';
require_once __DIR__.'/classes/WeatherService.php';
require_once __DIR__.'/classes/AbstractConfigForm.php';

class Weather extends AbstractConfigForm {


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

		$this->name = "weather";
		$this->tab = "Weather Management";
		$this->version = '1.0.0';
		$this->displayName = $this->l('Weather');

		$this->author = 'certideal';

		parent::__construct();
	}


	// ====================
	// === Hook Methods ===
	// ====================

	public function hookDisplayHome() {
		$citiesList = new  CitiesList('post');
		$citiesList->initContent();
	}


	// ==================================
	// === Override Certideal Methods ===
	// ==================================

	/**
	 * {@inheritDoc}
	 * @see \Certideal\PrestashopHelpers\CertidealAbstractModule::getModuleTabs()
	 */
	protected function getModuleTabs() {
		$languages = Language::getLanguages(false);
		$weather = [];
		$cityManagement = [];
		foreach ($languages as $lang) {
			$weather[$lang['id_lang']] = $this->l('Weather');
			$cityManagement[$lang['id_lang']] = $this->l('City Management');
		}

		return [
			[
				'name' => $weather,
				'class_name' => 'AdminWeather',
				'id_parent' => 0,
				'child_tab' => false,
				'active' => true,
			],
			[
				'name' => $cityManagement,
				'class_name' => 'AdminCity',
				'id_parent' => 0, // Will be set to the ID of the "Weather" tab during installation
				'child_tab' => true, // This is a child tab
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
		return $this->name;
	}

	/**
	 * {@inheritDoc}
	 * @see CertidealAbstractModule::getModuleTabName()
	 */
	protected function getModuleTabName() {
		return $this->tab;
	}

	/**
	 * {@inheritDoc}
	 * @see CertidealAbstractModule::getModuleVersion()
	 */
	protected function getModuleVersion() {
		return $this->version;
	}

	/**
	 * {@inheritDoc}
	 * @see CertidealAbstractModule::getDisplayName()
	 */
	protected function getDisplayName() {
		return $this->displayName;
	}
}
