<?php

namespace Startcode\Collection;

use Startcode\ValueObject\{ArrayList, Dictionary};
use Startcode\Collection\Factory\ReconstituteInterface;

class CollectionDictionary implements \Iterator, \Countable
{
    /**
     * @var Dictionary
     */
    private $dictionary;

    /**
     * @var ReconstituteInterface
     */
    private $factory;

    /**
     * @var int
     */
    private $total;

    /**
     * @var array
     */
    private $keyMap;

    /**
     * @var array
     */
    private $rawData;

    /**
     * @var int
     */
    private $pointer;

    /**
     * @var array
     */
    private $objects;

    public function __construct(Dictionary $dictionary, ReconstituteInterface $factory)
    {
        $this->dictionary = $dictionary;
        $this->factory    = $factory;
        $this->keyMap     = array_keys($dictionary->getAll());
        $this->rawData    = $dictionary->getAll();
        $this->pointer    = 0;
        $this->objects    = [];
    }

    /**
     * Count elements of an object
     */
    public function count() : int
    {
        if ($this->total === null) {
            $this->total = count($this->dictionary->getAll());
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

    public function next() : void
    {
        if ($this->pointer < $this->count()) {
            $this->pointer++;
        }
    }

    public function key() : int
    {
        return $this->pointer;
    }

    public function valid() : bool
    {
        return $this->current() !== null;
    }

    public function rewind() : self
    {
        $this->pointer = 0;
        return $this;
    }

    public function hasData() : bool
    {
        return $this->count() > 0;
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

    public function reduce(ArrayList $arrayList) : self
    {
        $this->keyMap = array_values($arrayList->getAll());
        return $this;
    }

    private function hasCurrentRawData() : bool
    {
        return isset($this->keyMap[$this->pointer]) && isset($this->rawData[$this->keyMap[$this->pointer]]);
    }

    private function hasCurrentObject() : bool
    {
        return isset($this->objects[$this->pointer]);
    }

    private function currentRawData() : array
    {
        return $this->rawData[$this->keyMap[$this->pointer]];
    }

    private function addCurrentRawDataToObjects() : void
    {
        $this->factory->set(new Dictionary($this->currentRawData()));
        $this->objects[$this->pointer] = $this->factory->reconstitute();
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
