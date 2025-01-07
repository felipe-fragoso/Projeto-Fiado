<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\LojaService;

class ClienteValidate extends Validator
{
    /**
     * @param $id
     * @param $cpf
     * @param $name
     * @param $email
     * @param $password
     * @param $date
     */
    public function __construct($id, $cpf, $name, $email, #[\SensitiveParameter] $password, $date)
    {
        $this->setItem('id', $id);
        $this->setItem('cpf', $cpf);
        $this->setItem('nome', $name);
        $this->setItem('email', $email);
        $this->setItem('senha', $password);
        $this->setItem('data', $date);

        $this->getItem('id')->isNumeric()->or()->isNull();
        $this->getItem('cpf')->isRequired()->isCpf();
        $this->getItem('nome')->isRequired()->isMaxLength(150);
        $this->getItem('email')->isRequired()->isEmail()->isMaxLength(150);
        $this->getItem('senha')->isNull()->or()->isMinLength(4)->isMaxLength(60);
        $this->getItem('data')->isRequired()->isDate();

        if ($id === null) {
            $this->getItem('email')->isUnique(ClienteService::getClienteByEmail($email) || LojaService::getLojaByEmail($email));
        }
    }
}