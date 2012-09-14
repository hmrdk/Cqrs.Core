<?php
namespace Cqrs\Core\EventStore\Backend;

interface EventStoreBackend {

	/**
	 * @param int $aggregateId
	 * @param array $events
	 * @return void
	 */
	public function insert($aggregateId, $events);

	/**
	 * @param int $aggregateId
	 * @return array
	 */
	public function find($aggregateId);

}
?>