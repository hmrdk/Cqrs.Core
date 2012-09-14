<?php
namespace Cqrs\Core\Tests\Functional\EventStore;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Proxy(false)
 */
class TestEvent implements \Cqrs\Core\Event {

	/**
	 * @var string
	 */
	public $message;

	/**
	 * @param string $message
	 */
	public function __construct($message) {
		$this->message = $message;
	}

}
?>