<?php
namespace Cqrs\Core\Tests\Functional\Repository\Event;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Proxy(false)
 */
class ItemCreatedEvent implements \Cqrs\Core\Event {

	/**
	 * @var int
	 */
	public $aggregateId;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @param int $aggregateId
	 * @param string $title
	 */
	public function __construct($aggregateId, $title) {
		$this->aggregateId = $aggregateId;
		$this->title = $title;
	}
}
?>