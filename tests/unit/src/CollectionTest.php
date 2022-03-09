<?php

use Startcode\ValueObject\ArrayList;
use Startcode\Collection\Collection;
use Startcode\Collection\Factory\ReconstituteInterface;

class CollectionTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var array
     */
    private $data;


    protected function setUp() : void
    {
        $this->data = [
            0 => [
                'id' => 1,
                'data' => 'lorem ipsum',
            ],
            2 => [
                'id' => 2,
                'data' => 'lorem ipsum',
            ],
        ];
        $this->collection = new Collection($this->data, $this->getMockForFactoryReconstituteInterface());
    }

    protected function tearDown() : void
    {
        $this->data       = null;
        $this->collection = null;
    }


    public function testCount()
    {
        $this->assertEquals(2, count($this->collection));
        $this->assertEquals(0, count(new Collection([], $this->getMockForFactoryReconstituteInterface())));
    }

    public function testCurrent()
    {
        $this->assertEquals($this->getMockForDomainEntity(), $this->collection->current());
        $this->assertEquals(0, $this->collection->key());
    }

    public function testGetRawData()
    {
        $this->assertEquals($this->data, $this->collection->getRawData());
    }

    public function testHasData()
    {
        $this->assertTrue($this->collection->hasData());

        $collection = new Collection([], $this->getMockForFactoryReconstituteInterface());
        $this->assertFalse($collection->hasData());
    }

    public function testIteration()
    {
        $domains = [];
        foreach($this->collection as $domain) {
            $domains[] = $domain;
        }
        $this->assertEquals(2, count($domains));
        $this->assertEquals($this->getMockForDomainEntity(), $domains[0]);
        $this->assertEquals($this->getMockForDomainEntity(), $domains[1]);
    }

    public function testKeyMapReverseOrder()
    {
        $this->assertEquals([0=>0, 1=>2], $this->collection->getKeyMap());

        $this->collection->keyMapReverseOrder();
        $this->assertEquals([0=>2, 1=>0], $this->collection->getKeyMap());
    }

    public function testIterationReduced()
    {
        $this->collection->reduce(new ArrayList([2]));
        $domains = [];
        foreach($this->collection as $domain) {
            $domains[] = $domain;
        }
        $this->assertEquals(1, count($domains));
        $this->assertEquals($this->getMockForDomainEntity(), $domains[0]);
}

    public function testNext()
    {
        $this->collection->next();
        $this->assertEquals(1, $this->collection->key());
        $this->collection->next();
        $this->assertNull($this->collection->current());
        $this->assertEquals(2, $this->collection->key());
    }

    public function testRewind()
    {
        $this->collection->rewind();
        $this->assertEquals(0, $this->collection->key());
    }

    public function testValid()
    {
        $this->assertTrue($this->collection->valid());
        $this->collection->next();
        $this->assertTrue($this->collection->valid());
        $this->collection->next();
        $this->assertFalse($this->collection->valid());
    }

    public function testLast()
    {
        $object = $this->collection->last();
        $this->assertEquals($this->getMockForFactoryReconstituteInterface()->reconstitute(), $object);
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
