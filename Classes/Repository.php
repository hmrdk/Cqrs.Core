<?php
namespace Cqrs\Core;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("singleton")
 */
abstract class Repository {

	/**
	 * @var \Cqrs\Core\EventStore\EventStore
	 * @FLOW3\Inject
	 */
	protected $eventStore;

	/**
	 * @param \Cqrs\Core\Aggregate $aggregate
	 * @return void
	 */
	public function add(\Cqrs\Core\Aggregate $aggregate) {
		$this->update($aggregate);
	}

	/**
	 * @param \Cqrs\Core\Aggregate $aggregate
	 * @return void
	 */
	public function update(\Cqrs\Core\Aggregate $aggregate) {
		$this->eventStore->saveEvents($aggregate->getAggregateId(), $aggregate->getAndResetUncommittedEvents());
	}

	/**
	 * @param string $aggregateId
	 * @throws Exception\NoAggregateFoundException
	 * @return \Cqrs\Core\Aggregate
	 */
	public function findById($aggregateId) {
		$events = $this->eventStore->getEventsForAggregate($aggregateId);

		if(empty($events)) {
			throw new \Cqrs\Core\Exception\NoAggregateFoundException('No aggregate found with id ' . $aggregateId);
		}

		$aggregate = $this->getEmptyAggregate();

		foreach ($events as $event) {
			$aggregate->apply($event, FALSE);
		}

		return $aggregate;
	}

	/**
	 * @return \Cqrs\Core\Aggregate
	 */
	protected function getEmptyAggregate() {
		$class = explode('\\', get_class($this));

		$class[count($class)-2] = 'Model';
		$class[count($class)-1] = substr($class[count($class)-1], 0, -1*strlen('Repository'));

		$class = implode('\\', $class);

		return unserialize(sprintf('O:%d:"%s":0:{}', strlen($class), $class));
	}

}
?>