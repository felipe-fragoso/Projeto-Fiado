<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Entity\Cliente;
use Fiado\Models\Entity\Loja;

class ClienteLojaValidate extends Validator
{
    /**
     * @param $id
     * @param $loja
     * @param $cliente
     * @param $maxCredit
     * @param $active
     */
    public function __construct($id, #[\SensitiveParameter] $loja, #[\SensitiveParameter] $cliente, $maxCredit, $active)
    {
        $this->setItem('id', $id);
        $this->setItem('cliente', $cliente);
        $this->setItem('loja', $loja);
        $this->setItem('credito maximo', $maxCredit);
        $this->setItem('ativo', $active);

        $this->getItem('id')->isNumeric()->or()->isNull();
        $this->getItem('cliente')->isRequired('')->isInstanceOf(Cliente::class, '')->isPresent($cliente?->getId());
        $this->getItem('loja')->isRequired()->isInstanceOf(Loja::class)->isPresent($loja?->getId());
        $this->getItem('credito maximo')->isNumeric()->or()->isNull('')->isMinValue(0);
        $this->getItem('ativo')->isRequired()->isBool();
    }
}