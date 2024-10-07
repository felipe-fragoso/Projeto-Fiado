<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Entity\Cliente;

class ClienteValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param Cliente $store
     * @return ClienteValidate
     */
    public function __construct($id, $cpf, $name, $email, $password)
    {
        if (!is_numeric($cpf)) {
            $this->addError('CPF Inválido.');
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