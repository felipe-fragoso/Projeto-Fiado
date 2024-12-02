<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Entity\Loja;

class ConfigValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param $id
     * @param Loja $loja
     * @param $payLimit
     * @param $maxCredit
     * @return mixed
     */
    public function __construct($id, Loja $loja, $payLimit, $maxCredit)
    {
        if (!$loja->getId()) {
            $this->addError('Loja inválida.');
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