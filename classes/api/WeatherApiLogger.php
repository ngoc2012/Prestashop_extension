<?php

use Certideal\CertiLogger\CertiLogger;
use Certideal\RequestSender\Common\LoggerInterface;

class WeatherApiLogger implements LoggerInterface {

	// =============
	// = Variables =
	// =============

	/** @var CertiLogger $logger instance of CertiLogger */
	private $logger;

	// ===================
	// === Constructor ===
	// ===================

	/**
	 * Init new BuyboxLogger provinding logger.
	 */
	private function __construct(CertiLogger $logger = null) {
		$this->logger = $logger;
	}

	// ======================
	// === Public Methods ===
	// ======================

	/**
	 * Get instance of the logger
	 * @param int $level Logger level
	 * @param int $backTraceDepth Logger backtrace depth
	 * @param string $moduleName module name use the logger
	 * 
	 * @return WeatherApiLogger
	 */
	public static function getInstance($level = CertiLogger::LOGGER_LEVEL_INFO, $backTraceDepth = CertiLogger::LOGGER_BACKTRACE_DEPTH, $moduleName = null) {
		return new WeatherApiLogger(CertiLogger::getInstance($level, $backTraceDepth, $moduleName));
	}

	/**
	 * {@inheritDoc}
	 * @see LoggerInterface::addLog()
	 */
	public function addLog($message = '', $extraInfos = null, $level = self::LEVEL_INFO) {
		$message = $extraInfos ? $message . ' - ' . $extraInfos : $message;
		$this->logger->addLog($message, $level);
	}

	/**
	 * {@inheritDoc}
	 * @see LoggerInterface::addErrorLog()
	 */
	public function addErrorLog($message = '', $level = self::LEVEL_ERROR) {
		$this->logger->addErrorLog($message, $level);
	}

	/**
	 * {@inheritDoc}
	 * @see LoggerInterface::addLogTraceEntering()
	 */
	public function addLogTraceEntering($function = '', $item = null) {
		$this->logger->addLogTraceEntering($item);
	}

	/**
	 * {@inheritDoc}
	 * @see LoggerInterface::addLogTraceExiting()
	 */
	public function addLogTraceExiting($function = '', $item = null) {
		$this->logger->addLogTraceExiting($item);
	}
}
