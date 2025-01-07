<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Entity\Fiado;
use Fiado\Models\Entity\Produto;

class FiadoItemValidate extends Validator
{
    /**
     * @param $id
     * @param $fiado
     * @param $produto
     * @param $value
     * @param $quantity
     */
    public function __construct($id, #[\SensitiveParameter] $fiado, #[\SensitiveParameter] $produto, $value, $quantity)
    {
        $this->setItem('id', $id);
        $this->setItem('fiado', $fiado);
        $this->setItem('produto', $produto);
        $this->setItem('valor', $value);
        $this->setItem('quantidade', $quantity);

        $this->getItem('id')->isNumeric()->or()->isNull();
        $this->getItem('fiado')->isRequired()->isInstanceOf(Fiado::class)->isPresent($fiado?->getId());
        $this->getItem('produto')->isRequired()->isInstanceOf(Produto::class)->isPresent($produto?->getId());
        $this->getItem('valor')->isRequired()->isNumeric()->isMaxValue(10 ** 8 - 0.01)->isMinValue(0.01);
        $this->getItem('quantidade')->isRequired()->isNumeric()->isMinValue(1);
    }
}