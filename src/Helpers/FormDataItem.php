<?php

namespace Fiado\Helpers;

use Fiado\Enums\FormDataType;
use Fiado\Enums\InputType;

class FormDataItem
{
    public string $name;
    public mixed $value;
    public mixed $defaultValue;
    private FormDataType $dataType;

    /**
     * @param FormDataType $dataType
     */
    public function __construct(FormDataType $dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @param string $name
     * @param $default
     * @param nullInputType $type
     */
    public function getValueFrom(string $name, $default = null, InputType $type = InputType::Post)
    {
        $this->name = $name;
        $this->defaultValue = $default;
        $this->value = call_user_func_array($this->dataType->getCallable(), [$name, $default, $type]);
    }
}