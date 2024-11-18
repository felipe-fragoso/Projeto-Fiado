<?php

namespace Fiado\Helpers;

use Closure;

class LazyDataObj
{
    /**
     * @var mixed
     */
    private $id;
    private Closure $getDataFunction;
    /**
     * @var mixed
     */
    private $object;

    /**
     * @param $id
     * @param $getDataFunction
     */
    public function __construct($id, $getDataFunction)
    {
        $this->id = $id;
        $this->getDataFunction = $getDataFunction;
    }

    private function initializeObj()
    {
        $this->object = ($this->getDataFunction)($this->id);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (!isset($this->object)) {
            $this->initializeObj();
        }

        return $this->object->$name;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (!isset($this->object)) {
            $this->initializeObj();
        }

        return $this->object->$name(...$arguments);
    }
}