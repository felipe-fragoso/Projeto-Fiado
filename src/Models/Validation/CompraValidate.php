<?php

namespace Fiado\Models\Validation;

use Fiado\Models\Entity\Cliente;
use Fiado\Models\Entity\Loja;
use Fiado\Models\Service\ClienteLojaService;
use Fiado\Models\Service\CompraService;
use Fiado\Models\Service\ConfigService;

class CompraValidate
{
    /**
     * @var mixed
     */
    private $errors;
    private int $numErrors = 0;

    /**
     * @param Cliente $cliente
     * @param Loja $loja
     * @param $total
     * @param $date
     * @param $dueDate
     * @param $paid
     * @return mixed
     */
    public function __construct(Cliente $cliente, Loja $loja, $total, $date, $dueDate, $paid)
    {
        if (!$cliente->getId()) {
            $this->addError('Cliente inválido');
        }

        if (!$loja->getId()) {
            $this->addError('Loja inválida');
        }

        $clienteLoja = ClienteLojaService::getClienteLoja($loja->getId(), $cliente->getId()) ?: null;
        $configLoja = ConfigService::getConfigByLoja($loja->getId()) ?: null;
        $totalPendente = CompraService::getTotalCliente($loja->getId(), $cliente->getId(), 0, new \DateTime, false);
        $maxCredit = $clienteLoja?->getMaxCredit() ?: $configLoja?->getMaxCredit();

        if (($total + $totalPendente) > $maxCredit) {
            $this->addError('Valor excede limite de crédito do cliente');
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