<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Service\ClienteService;

class ClienteValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param $id
     * @param $cpf
     * @param $name
     * @param $email
     * @param $password
     * @return mixed
     */
    public function __construct($id, $cpf, $name, $email, $password)
    {
        if (!is_numeric($cpf)) {
            $this->addError('CPF Inválido.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('Email Inválido');
        }

        if ($id === null && ClienteService::getClienteByEmail($email)) {
            $this->addError('Email existente');
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