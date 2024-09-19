<?php

namespace Fiado\Helpers;

class ParamItem
{
    private string $label;
    private mixed $value;
    private int $type;

    /**
     * @param string $name
     * @param mixed $value
     * @param int $type
     */
    public function __construct(string $name, mixed $value, int $type = \PDO::PARAM_STR)
    {
        $this->label = $name;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}