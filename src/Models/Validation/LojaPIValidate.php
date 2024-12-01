<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Entity\Loja;

class LojaPIValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param $id
     * @param Loja $loja
     * @param $address
     * @param $telephone
     * @param $description
     * @param $established
     * @param $openHour
     * @param $closeHour
     * @return mixed
     */
    public function __construct($id, Loja $loja, $address, $telephone, $description, $established, $openHour, $closeHour)
    {
        if (!$loja->getId()) {
            $this->addError('Loja Inválida.');
        }

        return $this;
    }

    /**
     * @param string $msg
     */
    public function addError(string $msg)
    {
        $this->numErrors++;

        $this->errors[] = ['msg' => $msg];
    }

    /**
     * @return int
     */
    public function getNumErrors()
    {
        return $this->numErrors;
    }
}