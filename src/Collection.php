<?php

namespace Startcode\Collection;

use Startcode\Collection\Factory\ReconstituteInterface;
use Startcode\ValueObject\ArrayList;

class Collection implements \Iterator, \Countable
{

    /**
     * @var ReconstituteInterface
     */
    private $factory;

    /**
     * @var array
     */
    private $keyMap;

    /**
     * @var array
     */
    private $objects;

    /**
     * @var int
     */
    private $pointer;

    /**
     * @var array
     */
    private $rawData;

    /**
     * @var int
     */
    private $total;

    public function __construct(array $rawData, ReconstituteInterface $factory)
    {
        $this->factory = $factory;
        $this->keyMap  = array_keys($rawData);
        $this->objects = [];
        $this->pointer = 0;
        $this->rawData = $rawData;
    }

    public function count() : int
    {
        if ($this->total === null) {
            $this->total = count($this->rawData);
        }
        return $this->total;
    }

    /**
     * @return mixed|null
     */
    public function current()
    {
        if ($this->pointer >= $this->count()) {
            return null;
        }
        if ($this->hasCurrentObject()) {
            return $this->currentObject();
        }
        if ($this->hasCurrentRawData()) {
            $this->addCurrentRawDataToObjects();
            return $this->currentObject();
        }
    }

    public function getRawData() : array
    {
        return $this->rawData;
    }

    public function getKeyMap() : array
    {
        return $this->keyMap;
    }

    public function keyMapReverseOrder() : self
    {
        $this->keyMap = array_reverse($this->keyMap);
        return $this;
    }

    public function reduce(ArrayList $algorithmList) : self
    {
        $this->keyMap = array_values($algorithmList->getAll());
        return $this;
    }

    public function hasData() : bool
    {
        return $this->count() > 0;
    }

    public function key() : int
    {
        return $this->pointer;
    }

    public function next() : void
    {
        if ($this->pointer < $this->count()) {
            $this->pointer++;
        }
    }

    public function rewind() : void
    {
        $this->pointer = 0;
    }

    public function valid() : bool
    {
        return $this->current() !== null;
    }

    private function addCurrentRawDataToObjects() : void
    {
        $this->factory->set($this->currentRawData());
        $this->objects[$this->pointer] = $this->factory->reconstitute();
    }

    /**
     * @return mixed
     */
    private function currentRawData()
    {
        return $this->rawData[$this->keyMap[$this->pointer]];
    }

    private function hasCurrentObject() : bool
    {
        return isset($this->objects[$this->pointer]);
    }

    private function hasCurrentRawData() : bool
    {
        return isset($this->keyMap[$this->pointer]) && isset($this->rawData[$this->keyMap[$this->pointer]]);
    }

    /**
     * @return mixed|null
     */
    private function currentObject()
    {
        return $this->hasCurrentObject()
            ? $this->objects[$this->pointer]
            : null;
    }
}
