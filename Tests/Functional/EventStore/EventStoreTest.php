<?php
namespace Cqrs\Core\Tests\Functional\EventStore;
use TYPO3\FLOW3\Annotations as FLOW3;

class EventStoreTest extends \TYPO3\FLOW3\Tests\FunctionalTestCase {

	/**
	 * @var \Cqrs\Core\EventStore\EventStore
	 */
	protected $eventStore;

	public function setUp() {
		parent::setUp();

		$this->eventStore = $this->objectManager->get('Cqrs\Core\EventStore\EventStore');
	}

	/**
	 * @test
	 */
	public function canPersistEvents() {
		$domainEvents = array(
			new TestEvent('Hello World'),
			new TestEvent('Hej Verden')
		);

		$aggregateId = 1234;

		$this->eventStore->saveEvents($aggregateId, $domainEvents);

		$events = $this->eventStore->getEventsForAggregate($aggregateId);

		$this->assertEquals(count($domainEvents), count($events));

		$event1 = $events[0];
		$event2 = $events[1];

		$this->assertInstanceOf('Cqrs\Core\Tests\Functional\EventStore\TestEvent', $event1);
		$this->assertInstanceOf('Cqrs\Core\Tests\Functional\EventStore\TestEvent', $event2);

		$this->assertEquals($domainEvents[0], $event1);
		$this->assertEquals($domainEvents[1], $event2);
	}
}

?>