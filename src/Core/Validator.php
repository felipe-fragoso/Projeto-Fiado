<?php

namespace Fiado\Core;

class Validator
{
    /** @var ValidatorItem[] */
    private $items = [];

    /**
     * @param string $name
     * @param $value
     */
    public function setItem(string $name, $value)
    {
        $this->items[$name] = new ValidatorItem($value);
    }

    /**
     * @param string $name
     * @return ?ValidatorItem
     */
    public function getItem(string $name)
    {
        if (isset($this->items[$name])) {
            return $this->items[$name];
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        $errors = [];
        foreach ($this->items as $key => $value) {
            $errors[$key] = $value->getErrors();
        }

        return $errors;
    }

    /**
     * @return int
     */
    public function getQtyErrors()
    {
        $qty = 0;
        foreach ($this->items as $value) {
            $qty += $value->getQtyErrors();
        }

        return $qty;
    }
}