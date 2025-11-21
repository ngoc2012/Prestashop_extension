<?php

require_once dirname(__FILE__).'/../../models/City.php';

use Certideal\PrestashopHelpers\CertidealAbstractModuleAdminController;

class AdminWeatherController extends CertidealAbstractModuleAdminController {


	// ===================
	// === Constructor ===
	// ===================

	public function __construct() {
		$this->bootstrap = true; // Enable PrestaShop 1.6 bootstrap styling

		$this->table = 'city';
		$this->className = 'City';
		$this->identifier = 'id_city';
		$this->lang = false;

		parent::__construct();

		// Define the columns for HelperList
		$this->fields_list = [
			'id_city' => [
				'title' => $this->l('ID'),
				'align' => 'center',
				'class' => 'fixed-width-xs',
			],
			'name' => [
				'title' => $this->l('City Name'),
			],
		];

		// Row actions
		$this->addRowAction('edit');
		$this->addRowAction('delete');

		// Toolbar button
		$this->toolbar_title = $this->l('City Management');
	}

	public function initPageHeaderToolbar() {
		parent::initPageHeaderToolbar();

		$this->page_header_toolbar_btn['new_city'] = [
			'href' => self::$currentIndex.'&addcity&token='.$this->token,
			'desc' => $this->l('Add new city'),
			'icon' => 'process-icon-new'
		];
	}

	public function renderList() {
		return parent::renderList();
	}

	public function renderForm() {
		// Form fields
		$this->fields_form = [
			'legend' => [
				'title' => $this->l('City'),
				'icon' => 'icon-globe'
			],
			'input' => [
				[
					'type' => 'text',
					'label' => $this->l('City name'),
					'name' => 'name',
					'required' => true,
				],
			],
			'submit' => [
				'title' => $this->l('Save'),
				'class' => 'btn btn-primary'
			]
		];
		return parent::renderForm();
	}

	/**
	 *
	 * {@inheritDoc}
	 * @see \Certideal\PrestashopHelpers\CertidealAbstractModuleAdminController::getObjectModelClassName()
	 */
	protected function getObjectModelClassName() {
		return 'City';
	}

	/**
	 *
	 * {@inheritDoc}
	 * @see \Certideal\PrestashopHelpers\CertidealAbstractModuleAdminController::getObjectModelTableName()
	 */
	protected function getObjectModelTableName() {
		return 'city';
	}
}
