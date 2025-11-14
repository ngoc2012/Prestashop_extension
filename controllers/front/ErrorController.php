<?php
namespace PrestaShop\Module\Weather\controllers\front;

use ContextCore;

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
	public static function init($message = null) {
		$context = ContextCore::getContext();
		$context->smarty->assign('errorMessage', $message);
		$context->smarty->assign('homeLink', $context->link->getPageLink('index'));
		$context->smarty->display('front/error.tpl');
	}
}
