<?php
namespace Cqrs\Core\EventStore\Backend;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("singleton")
 */
class MemoryEventStoreBackend implements EventStoreBackend {

	/**
	 * @var array
	 */
	protected $storage;

	/**
	 * @var array
	 */
	protected $allEvents;

	public function __construct() {
		$this->storage = array();
		$this->allEvents = array();
	}

	/**
	 * @param int $aggregateId
	 * @param array $events
	 * @return void
	 */
	public function insert($aggregateId, $events) {
		if(!array_key_exists($aggregateId, $this->storage)) {
			$this->storage[$aggregateId] = array();
		}

		foreach($events as $event) {
			$this->allEvents[] = $event;
			$this->storage[$aggregateId][] = $event;
		}
	}

	/**
	 * @param int $aggregateId
	 * @throws \NoAggregateFoundException
	 * @return array
	 */
	public function find($aggregateId) {
		if(!array_key_exists($aggregateId, $this->storage)) {
			throw new \NoAggregateFoundException();
		}

		return $this->storage[$aggregateId];
	}

	/**
	 * @return array
	 */
	public function getAllEvents() {
		return $this->allEvents;
	}





}
?>