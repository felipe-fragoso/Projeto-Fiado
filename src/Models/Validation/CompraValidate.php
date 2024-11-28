<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Entity\Cliente;
use Fiado\Models\Entity\Loja;

class CompraValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param Cliente $cliente
     * @param Loja $loja
     * @param $total
     * @param $date
     * @param $dueDate
     * @param $paid
     * @return mixed
     */
    public function __construct(Cliente $cliente, Loja $loja, $total, $date, $dueDate, $paid)
    {
        if (!$cliente->getId()) {
            $this->addError('Cliente inválido');
        }

        if (!$loja->getId()) {
            $this->addError('Loja inválida');
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