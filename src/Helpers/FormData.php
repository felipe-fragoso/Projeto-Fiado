<?php

namespace Fiado\Helpers;

use Fiado\Enums\FormDataType;

class FormData
{
    private array $itens = [];

    /**
     * @param string $name
     * @param FormDataType $dataType
     * @return FormDataItem
     */
    public function setItem(string $name, FormDataType $dataType = FormDataType::String): FormDataItem
    {
        return $this->itens[$name] = new FormDataItem($dataType);
    }

    /**
     * @param string $name
     * @return ?FormDataItem
     */
    public function getItem(string $name): ?FormDataItem
    {
        return $this->itens[$name];
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->itens[$name]?->value;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $array = [];

        foreach ($this->itens as $item) {
            $array[$item->name] = $item->value;
        }

        return $array;
    }
}