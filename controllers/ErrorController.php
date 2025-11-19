<?php

/**
* Controller for handling errors pages
*/
class ErrorController {


	// =========================
	// === Public Methods ======
	// =========================

	/**
	* Display an error message.
	* @param string $message
	* @return void
	*/
	public static function initContent($message = null) {
		$context = \ContextCore::getContext();
		$context->smarty->assign('errorMessage', $message);
		$context->smarty->assign('homeLink', $context->link->getPageLink('index'));
		$context->smarty->display( _PS_MODULE_DIR_ . 'weather/views/templates/error.tpl');
	}
}
