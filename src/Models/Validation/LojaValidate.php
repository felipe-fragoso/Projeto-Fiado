<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Entity\Loja;

class LojaValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param Loja $store
     * @return LojaValidate
     */
    public function __construct($id, $cnpj, $name, $email, $password)
    {
        if (!is_numeric($cnpj)) {
            $this->addError('CNPJ Inválido.');
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