<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Entity\Cliente;

class ClientePIValidate extends Validator
{
    /**
     * @param $id
     * @param $cliente
     * @param $address
     * @param $telephone
     * @param $description
     */
    public function __construct($id, #[\SensitiveParameter] $cliente, $address, $telephone, $description)
    {
        $this->setItem('id', $id);
        $this->setItem('cliente', $cliente);
        $this->setItem('endereco', $address);
        $this->setItem('telefone', $telephone);
        $this->setItem('descricao', $description);

        $this->getItem('id')->isNull()->or()->isNumeric();
        $this->getItem('cliente')->isRequired()->isInstanceOf(Cliente::class)->isPresent($cliente?->getId());
        $this->getItem('endereco')->isRequired()->isMaxLength(200);
        $this->getItem('telefone')->isRequired()->isPhoneNumber()->isMaxLength(20);
        $this->getItem('descricao')->isMaxLength(65533);
    }
}