<?php

use Startcode\Collection\PaginatedCollection;
use Startcode\ValueObject\Dictionary;
use Startcode\Collection\Factory\ReconstituteInterface;

class PaginatedCollectionTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var PaginatedCollection
     */
    private $collection;

    /**
     * @var array
     */
    private $dataMock;

    /**
     * @var int
     */
    private $fixture;


    protected function setUp() : void
    {
        $this->dataMock = $this->getMockBuilder(Dictionary::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fixture = 23;

        $this->dataMock
            ->expects($this->any())
            ->method('getAll')
            ->willReturn([
                0 => [
                    'id' => 1,
                    'data' => 'lorem ipsum',
                ],
                2 => [
                    'id' => 2,
                    'data' => 'lorem ipsum',
                ]
            ]);

        $this->collection = new PaginatedCollection($this->dataMock->getAll(), $this->getMockForFactoryReconstituteInterface());
    }

    protected function tearDown() : void
    {
        $this->fixture      = null;
        $this->dataMock     = null;
        $this->collection   = null;
    }

    public function testCurrentItemsCount()
    {
        $this->collection->setCurrentItemsCount($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getCurrentItemsCount());
    }

    public function testCurrentPageNumber()
    {
        $this->collection->setCurrentPageNumber($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getCurrentPageNumber());
    }

    public function testItemsCountPerPage()
    {
        $this->collection->setItemsCountPerPage($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getItemsCountPerPage());
    }

    public function testPageCount()
    {
        $this->collection->setPageCount($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getPageCount());
    }

    public function testTotalItemsCount()
    {
        $this->collection->setTotalItemsCount($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getTotalItemsCount());
    }

    public function testMap()
    {
        $this->collection->setCurrentPageNumber($this->fixture);
        $this->collection->setTotalItemsCount($this->fixture);
        $this->collection->setItemsCountPerPage($this->fixture);
        $this->collection->setCurrentItemsCount($this->fixture);
        $this->collection->setPageCount($this->fixture);

        $map = [
            'current_items'         => $this->dataMock->getAll(),
            'current_page_number'   => $this->fixture,
            'total_item_count'      => $this->fixture,
            'item_count_per_page'   => $this->fixture,
            'current_item_count'    => $this->fixture,
            'page_count'            => $this->fixture,
        ];

        $this->assertEquals($map, $this->collection->map());
    }

    private function getMockForFactoryReconstituteInterface()
    {
        $mock = $this->getMockBuilder(ReconstituteInterface::class)
            ->setMethods(['set', 'reconstitute'])
            ->getMock();

        $mock
            ->expects($this->any())
            ->method('set');

        $mock
            ->expects($this->any())
            ->method('reconstitute')
            ->willReturn($this->getMockForDomainEntity());

        return $mock;
    }

    private function getMockForDomainEntity()
    {
        return $this->getMockBuilder('Domain')->getMock();
    }
}
