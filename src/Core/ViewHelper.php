<?php

namespace Fiado\Core;

class ViewHelper extends \stdClass

{
    /**
     * @param array $array
     */
    public function __construct(array $array)
    {
        foreach ($array as $key => $value) {
            if (!property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @param string $property
     */
    public function dateToBr(string $property)
    {
        if (property_exists($this, $property)) {
            return date('d/m/Y H:i:s', strtotime($this->$property));
        }

        return null;
    }

    /**
     * @param string $property
     */
    public function formatToReal(string $property)
    {
        if (property_exists($this, $property)) {
            return number_format($this->$property, 2, ',', '.');
        }

        return false;
    }
}