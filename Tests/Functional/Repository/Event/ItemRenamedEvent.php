<?php
namespace Cqrs\Core\Tests\Functional\Repository\Event;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Proxy(false)
 */
class ItemRenamedEvent implements \Cqrs\Core\Event {

	/**
	 * @var int
	 */
	public $aggregateId;

	/**
	 * @var string
	 */
	public $newTitle;

	/**
	 * @param int $aggregateId
	 * @param string $newTitle
	 */
	public function __construct($aggregateId, $newTitle) {
		$this->aggregateId = $aggregateId;
		$this->newTitle = $newTitle;
	}
}
?>