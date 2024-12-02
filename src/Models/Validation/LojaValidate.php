<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\LojaService;

class LojaValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param $id
     * @param $cnpj
     * @param $name
     * @param $email
     * @param $password
     * @return mixed
     */
    public function __construct($id, $cnpj, $name, $email, $password)
    {
        if (!is_numeric($cnpj)) {
            $this->addError('CNPJ Inválido.');
        }

        if ($id === null && (LojaService::getLojaByEmail($email) || ClienteService::getClienteByEmail($email))) {
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