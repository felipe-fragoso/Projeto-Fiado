<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Entity\Cliente;
use Fiado\Models\Entity\Loja;

class ClienteCompletionLinkValidate extends Validator
{
    /**
     * @param $id
     * @param $hash
     * @param $cliente
     * @param $loja
     * @param $used
     * @param $validUntil
     */
    public function __construct($id, $hash, #[\SensitiveParameter] $cliente, #[\SensitiveParameter] $loja, $used, $validUntil)
    {
        $this->setItem('id', $id);
        $this->setItem('hash', $hash);
        $this->setItem('cliente', $cliente);
        $this->setItem('loja', $loja);
        $this->setItem('usado', $used);
        $this->setItem('valido ate', $validUntil);

        $this->getItem('id')->isNull()->or()->isNumeric();
        $this->getItem('hash')->isRequired()->isMaxLength(64);
        $this->getItem('cliente')->isRequired('')->isInstanceOf(Cliente::class, '')->isPresent($cliente?->getId(), '');
        $this->getItem('loja')->isRequired('')->isInstanceOf(Loja::class, '')->isPresent($loja?->getId(), '');
        $this->getItem('usado')->isRequired()->isBool();
        $this->getItem('valido ate')->isRequired()->isDate();
    }
}