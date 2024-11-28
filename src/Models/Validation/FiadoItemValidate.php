<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Entity\Fiado;
use Fiado\Models\Entity\Produto;

class FiadoItemValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param Fiado $fiado
     * @param Produto $produto
     * @param $value
     * @param $quantity
     * @return mixed
     */
    public function __construct(Fiado $fiado, Produto $produto, $value, $quantity)
    {
        if (!$fiado->getId()) {
            $this->addError('Fiado inválido');
        }

        if (!$produto->getId()) {
            $this->addError('Produto inválido');
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