<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Entity\Fiado;

class StripeInvoiceValidate extends Validator
{
    /**
     * @param $id
     * @param $fiado
     * @param $idInvoice
     */
    public function __construct($id, #[\SensitiveParameter] $fiado, $idInvoice)
    {
        $this->setItem('id', $id);
        $this->setItem('fiado', $fiado);
        $this->setItem('id_invoice', $idInvoice);

        $this->getItem('id')->isNumeric()->or()->isNull();
        $this->getItem('fiado')->isRequired()->isInstanceOf(Fiado::class)->isPresent($fiado?->getId());
        $this->getItem('id_invoice')->isRequired()->isMaxLength('255');
    }
}