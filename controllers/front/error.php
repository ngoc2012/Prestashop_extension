<?php

/**
* Controller for handling errors pages
*/
class WeatherErrorModuleFrontController extends \ModuleFrontController {


	// =========================
	// === Public Methods ======
	// =========================

	/**
	* Display an error message.
	* @param string $message
	* @return void
	*/
	public function initContent($message = null) {
		$this->context = \ContextCore::getContext();
		parent::initContent();
		$this->context->smarty->assign('errorMessage', $message);
		$this->context->smarty->assign('homeLink', $this->context->link->getPageLink('index'));
		$this->context->smarty->display('front/error.tpl');
	}
}
