<?php

namespace Fiado\Models\Validation;

class ProdutoValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param $name
     * @param $price
     * @param $active
     * @param $description
     * @return mixed
     */
    public function __construct($name, $price, $active, $description)
    {
        if (!is_numeric($price)) {
            $this->addError('Preço Inválido.');
        }

        return $this;
    }

    /**
     * @param string $msg
     */
    public function addError(string $msg)
    {
        $this->numErrors++;

        $this->errors[] = ['msg' => $msg];
    }

    /**
     * @return int
     */
    public function getNumErrors()
    {
        return $this->numErrors;
    }
}