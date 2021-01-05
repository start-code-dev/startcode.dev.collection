<?php

namespace Startcode\Collection\Factory;

abstract class FromArrayAbstract
{

    private array $data;

    public function __construct(array $data = null)
    {
        $this->set($data);
    }

    public function get(string $key = null)
    {
        return $key === null
            ? $this->data
            : ($this->has($key) ? $this->data[$key] : null);
    }

    public function has(string $key) : bool
    {
        return isset($this->data[$key]);
    }

    public function hasNonEmptyValue($key) : bool
    {
        return $this->has($key) && !empty($this->data[$key]);
    }

    public function hasData() : bool
    {
        return is_array($this->data) && count($this->data) > 0;
    }

    public function set($data = null) : self
    {
        $this->data = [];
        if ($data !== null && is_array($data)) {
            $this->data = $data;
        }
        return $this;
    }
}
