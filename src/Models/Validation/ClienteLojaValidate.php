<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Entity\Cliente;
use Fiado\Models\Entity\Loja;

class ClienteLojaValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param $id
     * @param Loja $loja
     * @param Cliente $cliente
     * @param $maxCredit
     * @param $active
     * @return mixed
     */
    public function __construct($id, Loja $loja, Cliente $cliente, $maxCredit, $active)
    {
        if (!is_numeric($maxCredit) && $maxCredit !== null) {
            $this->addError('Fiado máximo Inválido.');
        }

        if (!$loja?->getId()) {
            $this->addError('Loja inválida');
        }

        if (!$cliente->getId()) {
            $this->addError('Cliente inválido');
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