<?php
namespace Cqrs\Core\Tests\Functional\Repository\Model;
use TYPO3\FLOW3\Annotations as FLOW3;

class Item extends \Cqrs\Core\Aggregate {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @param int $aggregateId
	 * @param string $title
	 * @throws \InvalidArgumentException
	 */
	public function __construct($aggregateId, $title) {
		$aggregateId = intval($aggregateId);
		if($aggregateId<=0) {
			throw new \InvalidArgumentException('Aggregated id is required');
		}

		$title = trim($title);
		if(empty($title)) {
			throw new \InvalidArgumentException('Title is required');
		}

		$this->apply(new \Cqrs\Core\Tests\Functional\Repository\Event\ItemCreatedEvent($aggregateId, $title));
	}

	/**
	 * @param \Cqrs\Core\Tests\Functional\Repository\Event\ItemCreatedEvent $event
	 */
	public function applyItemCreatedEvent(\Cqrs\Core\Tests\Functional\Repository\Event\ItemCreatedEvent $event) {
		$this->aggregateId = $event->aggregateId;
		$this->title = $event->title;
	}

	/**
	 * @param string $newTitle
	 * @throws \InvalidArgumentException
	 * @return void
	 */
	public function rename($newTitle) {
		$newTitle = trim($newTitle);
		if(empty($newTitle) || $newTitle === $this->title) {
			throw new \InvalidArgumentException('NewTitle must not be empty and different than current title');
		}

		$this->apply(new \Cqrs\Core\Tests\Functional\Repository\Event\ItemRenamedEvent($this->aggregateId, $newTitle));
	}

	/**
	 * @param \Cqrs\Core\Tests\Functional\Repository\Event\ItemRenamedEvent $event
	 */
	public function applyItemRenamedEvent(\Cqrs\Core\Tests\Functional\Repository\Event\ItemRenamedEvent $event) {
		$this->title = $event->newTitle;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return array(
			'aggregate_id'=>$this->getAggregateId(),
			'title'=>$this->title
		);
	}




}
?>