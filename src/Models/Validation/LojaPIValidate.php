<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Entity\Loja;

class LojaPIValidate extends Validator
{
    /**
     * @param $id
     * @param $loja
     * @param $address
     * @param $telephone
     * @param $description
     * @param $established
     * @param $openHour
     * @param $closeHour
     */
    public function __construct($id, #[\SensitiveParameter] $loja, $address, $telephone, $description, $established, $openHour, $closeHour)
    {
        $this->setItem('id', $id);
        $this->setItem('loja', $loja);
        $this->setItem('endereco', $address);
        $this->setItem('telefone', $telephone);
        $this->setItem('descricao', $description);
        $this->setItem('fundado', $established);
        $this->setItem('abre', $openHour);
        $this->setItem('fecha', $closeHour);

        $this->getItem('id')->isNull()->or()->isNumeric();
        $this->getItem('loja')->isRequired()->isInstanceOf(Loja::class)->isPresent($loja?->getId());
        $this->getItem('endereco')->isMaxLength(200);
        $this->getItem('telefone')->isMaxLength(20)->isPhoneNumber();
        $this->getItem('descricao')->isMaxLength(65533);
        $this->getItem('fundado')->isDate();
        $this->getItem('abre')->isDate();
        $this->getItem('fecha')->isDate();
    }
}