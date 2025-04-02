<?php

namespace Fiado\Core;

use Fiado\Helpers\SqidsWrapper;

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
            if ($this->$property === '0000-00-00 00:00:00') {
                return 'Sem data';
            }

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
            if (is_numeric($this->$property)) {
                return number_format($this->$property, 2, ',', '.');
            }
        }

        return false;
    }

    /**
     * @param string $property
     * @param int $decimals
     * @param string $decimal_separator
     * @param string $thousands_separator
     */
    public function formatNumber(string $property, int $decimals = 0, string $decimal_separator = '.', string $thousands_separator = ',')
    {
        if (property_exists($this, $property)) {
            if (is_numeric($this->$property)) {
                return number_format($this->$property, $decimals, $decimal_separator, $thousands_separator);
            }
        }

        return false;
    }

    /**
     * @param string $property
     */
    public function formatPhone(string $property)
    {
        if (property_exists($this, $property)) {
            return preg_replace('/(\d{2})(\d{4,5})(\d{4})/', '($1) $2-$3', $this->$property);
        }
    }

    /**
     * @param string $property
     */
    public function formatIdx(string $property)
    {
        if (property_exists($this, $property)) {
            return SqidsWrapper::encode($this->$property);
        }
    }

    /**
     * @param string $property
     */
    public function formatCpf(string $property)
    {
        if (property_exists($this, $property)) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->$property);
        }
    }

    /**
     * @param string $property
     */
    public function formatCnpj(string $property)
    {
        if (property_exists($this, $property)) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $this->$property);
        }
    }
}