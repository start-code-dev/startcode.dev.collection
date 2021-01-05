<?php

namespace Startcode\Collection\Factory;

abstract class FromStringAbstract
{

    private ?string $data = null;

    public function __construct(string $data = null)
    {
        $this->set($data);
    }

    public function get() : ?string
    {
        return $this->has() ? $this->data : null;
    }

    public function has() : bool
    {
        return $this->data !== null;
    }

    public function set($data = null) : self
    {
        $this->data = null;
        if ($data !== null) {
            $this->data = $data;
        }
        return $this;
    }
}
