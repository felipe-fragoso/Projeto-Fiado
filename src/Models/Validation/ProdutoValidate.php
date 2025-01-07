<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Entity\Loja;

class ProdutoValidate extends Validator
{
    /**
     * @param $id
     * @param $loja
     * @param $name
     * @param $price
     * @param $date
     * @param $description
     * @param $active
     */
    public function __construct($id, #[\SensitiveParameter] $loja, $name, $price, $date, $description, $active)
    {
        $this->setItem('id', $id);
        $this->setItem('loja', $loja);
        $this->setItem('nome', $name);
        $this->setItem('preco', $price);
        $this->setItem('data', $date);
        $this->setItem('descricao', $description);
        $this->setItem('ativo', $active);

        $this->getItem('id')->isNumeric()->or()->isNull();
        $this->getItem('loja')->isRequired()->isInstanceOf(Loja::class)->isPresent($loja?->getId());
        $this->getItem('nome')->isRequired()->isMaxLength('150');
        $this->getItem('preco')->isRequired()->isMaxValue(10 ** 8 - 0.01)->isMinValue(0.01);
        $this->getItem('data')->isRequired()->isDate();
        $this->getItem('descricao')->isMaxLength(65533);
        $this->getItem('ativo')->isRequired()->isBool();
    }
}