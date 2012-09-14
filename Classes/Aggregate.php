<?php
namespace Cqrs\Core;
use TYPO3\FLOW3\Annotations as FLOW3;

abstract class Aggregate {

	/**
	 * @var int
	 */
	protected $aggregateId;

	/**
	 * @var array
	 */
	private $uncommittedEvents = array();

	/**
	 * @param $event
	 * @param bool $new
	 * @throws \Exception
	 */
	public function apply($event, $new = TRUE) {
		$methodName = $this->getMethodNameFromEvent($event);

		if (!method_exists($this, $methodName)) {
			throw new \Exception('No method named ' . $methodName . ' exists in ' . get_class($this));
		}

		$this->$methodName($event);

		if ($new) {
			$this->uncommittedEvents[] = $event;
		}
	}

	/**
	 * @param $event
	 * @return string
	 */
	protected function getMethodNameFromEvent($event) {
		$class = explode('\\', get_class($event));
		$class = end($class);

		return 'apply' . $class;
	}

	/**
	 * @return int
	 */
	public function getAggregateId() {
		return $this->aggregateId;
	}

	/**
	 * @return array
	 */
	public function getAndResetUncommittedEvents() {
		$events = $this->uncommittedEvents;
		$this->uncommittedEvents = array();
		return $events;
	}
}

?>