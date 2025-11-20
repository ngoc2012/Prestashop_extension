<?php

use Certideal\RequestSender\Entity\Response\ResponseInterface;
use Certideal\RequestSender\Http\AbstractResponseHandler;
use Certideal\RequestSender\Common\RequestSenderException;
use Composer\Util\Http\Response;

require_once __DIR__ . "/FreeWeatherResponse.php";

class FreeWeatherResponseHandler extends AbstractResponseHandler {

	// =====================
	// = Overrided Methods =
	// =====================


	/**
	 * {@inheritDoc}
	 * @see AbstractResponseHandler::loadObject($unserializedData)
	 * @return ResponseInterface
	 */
	protected function loadObject($unserializedData) {
		return new FreeWeatherResponse($unserializedData);
	}

	/**
	 * {@inheritDoc}
	 * Overload to treat response that come in the from of text
	 *
	 * @see AbstractResponseHandler::handleResponse($status, $body)
	 */
	public function handleResponse($status, $body) {
		if ($this->getLogger()) {
			$this->getLogger()->addLogTraceEntering(__FUNCTION__, $status);

			$this->getLogger()->addLog($body, __FUNCTION__);
		}

		//-- Unserialize
		$unserializedResult = json_decode($body, true);

		if (!self::isSuccessResponseCode($status)) {
			throw new RequestSenderException(sprintf('Http%d - %s', $status, $unserializedResult));
		}
		//-- Parse results
		$response = $this->loadObject($unserializedResult);

		if ($this->getLogger()) {
			$this->getLogger()->addLogTraceExiting(__FUNCTION__);
		}
		return $response;
	}
}
