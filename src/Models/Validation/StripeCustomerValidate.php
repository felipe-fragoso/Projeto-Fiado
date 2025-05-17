<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;

class StripeCustomerValidate extends Validator
{
    /**
     * @param $id
     * @param $idCustomer
     * @param $email
     */
    public function __construct($id, $idCustomer, $email)
    {
        $this->setItem('id', $id);
        $this->setItem('id_customer', $idCustomer);
        $this->setItem('email', $email);

        $this->getItem('id')->isNumeric()->or()->isNull();
        $this->getItem('id_customer')->isRequired()->isMaxLength('255');
        $this->getItem('email')->isRequired()->isEmail()->isMaxLength(150);
    }
}