<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\LojaService;

class LojaValidate extends Validator
{
    /**
     * @param $id
     * @param $cnpj
     * @param $name
     * @param $email
     * @param $password
     * @param $date
     */
    public function __construct($id, $cnpj, $name, $email, #[\SensitiveParameter] $password, $date)
    {
        $this->setItem('id', $id);
        $this->setItem('cnpj', $cnpj);
        $this->setItem('nome', $name);
        $this->setItem('email', $email);
        $this->setItem('senha', $password);
        $this->setItem('data', $date);

        $this->getItem('id')->isNull()->or()->isNumeric();
        $this->getItem('cnpj')->isRequired()->isCnpj();
        $this->getItem('nome')->isRequired()->isMaxLength(150);
        $this->getItem('email')->isRequired()->isMaxLength(150)->isEmail();
        $this->getItem('senha')->isRequired()->isMaxLength(60)->isMinLength(4);
        $this->getItem('data')->isRequired()->isDate();

        if ($id === null) {
            $this->getItem('email')->isUnique(LojaService::getLojaByEmail($email) || ClienteService::getClienteByEmail($email));
        }
    }
}