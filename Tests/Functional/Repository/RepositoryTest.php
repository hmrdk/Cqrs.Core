<?php
namespace Cqrs\Core\Tests\Functional\Repository;
use TYPO3\FLOW3\Annotations as FLOW3;

class RepositoryTest extends \TYPO3\FLOW3\Tests\FunctionalTestCase  {

	/**
	 * @var \Cqrs\Core\Tests\Functional\Repository\Repository\ItemRepository
	 */
	protected $itemRepository;

	public function setUp() {
		parent::setUp();

		$this->itemRepository = $this->objectManager->get('Cqrs\Core\Tests\Functional\Repository\Repository\ItemRepository');
	}

	/**
	 * @test
	 */
	public function canPersistAndLoadItemWithOneEvent() {
		$item = new \Cqrs\Core\Tests\Functional\Repository\Model\Item(1234, 'Hello world');
		$this->itemRepository->add($item);

		unset($item);

		$item = $this->itemRepository->findById(1234);
		$this->assertSame(array(
			'aggregate_id'=>1234,
			'title'=>'Hello world'
		), $item->toArray());
	}

	/**
	 * @test
	 */
	public function canPersistAndLoadItemWithTwoEvent() {
		$item = new \Cqrs\Core\Tests\Functional\Repository\Model\Item(1234, 'Hello worrd');
		$item->rename('Hello world');
		$this->itemRepository->add($item);

		unset($item);

		$item = $this->itemRepository->findById(1234);
		$this->assertSame(array(
			'aggregate_id'=>1234,
			'title'=>'Hello world'
		), $item->toArray());
	}

}
?>