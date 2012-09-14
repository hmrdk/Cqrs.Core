<?php
namespace Cqrs\Core;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("singleton")
 */
abstract class EventListener {

	/**
	 * @var \TYPO3\FLOW3\Log\SystemLoggerInterface
	 * @FLOW3\Inject
	 */
	protected $systemLogger;

	/**
	 * @param Event $event
	 * @throws \Exception
	 */
	public function apply(Event $event) {
		$this->systemLogger->log(get_class($this) . '  tries to apply event', LOG_DEBUG, serialize($event));

		$methodName = 'apply_' . str_replace('\\', '_', get_class($event));

		if (method_exists($this, $methodName)) {
			$this->$methodName($event);
			$this->systemLogger->log(get_class($this) . '  applied event', LOG_DEBUG, serialize($event));
		}
	}

}
?>