<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Entity\Cliente;

class ClientePIValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param $id
     * @param Cliente $cliente
     * @param $address
     * @param $telephone
     * @param $description
     * @return mixed
     */
    public function __construct($id, Cliente $cliente, $address, $telephone, $description)
    {
        if (!$cliente->getId()) {
            $this->addError('Cliente inválido');
        }

        // Comentado até sanitizar dados
        // if (!is_numeric($telephone)) {
        //     $this->addError('Telefone Inválido.');
        // }

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