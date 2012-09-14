<?php
namespace Cqrs\Core\EventStore;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("singleton")
 */
class EventStore {

	/**
	 * @var \Cqrs\Core\EventStore\Backend\EventStoreBackend
	 * @FLOW3\Inject
	 */
	protected $backend;

	/**
	 * @param int $aggregateId
	 * @param array $events
	 * @return void
	 */
	public function saveEvents($aggregateId, $events) {
		if (count($events) > 0) {
			$this->backend->insert($aggregateId, $events);

			foreach($events as $event) {
				$this->emitEventPersisted($event);
			}
		}
	}

	/**
	 * @abstract
	 * @param int $aggregateId
	 * @return array
	 */
	public function getEventsForAggregate($aggregateId) {
		return $this->backend->find($aggregateId);
	}

	/**
	 * @param \Cqrs\Core\Event $event
	 * @return void
	 * @FLOW3\Signal
	 */
	protected function emitEventPersisted(\Cqrs\Core\Event $event) {}

}
?>