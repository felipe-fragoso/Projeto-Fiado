<?php

namespace Fiado\Helpers;

class ParamData
{
    private array $data = [];

    /**
     * @param ParamItem $item
     */
    public function __construct(?ParamItem $item)
    {
        if ($item) {
            $this->data[] = $item;
        }
    }

    /**
     * @param string $name
     * @param $value
     * @param int $type
     */
    public function addData(string $name, $value, int $type = \PDO::PARAM_STR)
    {
        $this->data[] = new ParamItem($name, $value, $type);
    }

    /**
     * @return ParamItem[]
     */
    public function getData()
    {
        return $this->data;
    }
}