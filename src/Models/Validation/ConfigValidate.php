<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Entity\Loja;

class ConfigValidate extends Validator
{
    /**
     * @param $id
     * @param $loja
     * @param $payLimit
     * @param $maxCredit
     */
    public function __construct($id, #[\SensitiveParameter] $loja, $payLimit, $maxCredit)
    {
        $this->setItem('id', $id);
        $this->setItem('loja', $loja);
        $this->setItem('prazo', $payLimit);
        $this->setItem('credito_maximo', $maxCredit);

        $this->getItem('id')->isNumeric()->or()->isNull();
        $this->getItem('loja')->isRequired()->isInstanceOf(Loja::class)->isPresent($loja?->getId());
        $this->getItem('prazo')->isRequired()->isNumeric()->isMinValue(1)->isMaxValue(999);
        $this->getItem('credito_maximo')->isRequired()->isNumeric()->isMinValue(0.01)->isMaxValue(9999);
    }
}