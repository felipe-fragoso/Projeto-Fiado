<?php

namespace Fiado\Models\Validation;

use Fiado\Core\Validator;
use Fiado\Models\Entity\Cliente;
use Fiado\Models\Entity\Loja;
use Fiado\Models\Service\ClienteLojaService;
use Fiado\Models\Service\CompraService;
use Fiado\Models\Service\ConfigService;

class CompraValidate extends Validator
{
    /**
     * @param $id
     * @param $cliente
     * @param $loja
     * @param $total
     * @param $date
     * @param $dueDate
     * @param $paid
     */
    public function __construct($id, #[\SensitiveParameter] $cliente, #[\SensitiveParameter] $loja, $total, $date, $dueDate, $paid)
    {
        $this->setItem('id', $id);
        $this->setItem('cliente', $cliente);
        $this->setItem('loja', $loja);
        $this->setItem('total', $total);
        $this->setItem('data', $date);
        $this->setItem('data_vencimento', $dueDate);
        $this->setItem('pago', $paid);

        $this->getItem('id')->isNumeric()->or()->isNull();
        $this->getItem('cliente')->isRequired()->isInstanceOf(Cliente::class)->isPresent($cliente?->getId());
        $this->getItem('loja')->isRequired()->isInstanceOf(Loja::class)->isPresent($loja?->getId());
        $this->getItem('total')->isRequired()->isNumeric()->isMinValue(0.01)->isMaxValue(10 ** 8 - 0.01);
        $this->getItem('data')->isRequired()->isDate();
        $this->getItem('data_vencimento')->isRequired()->isDate();
        $this->getItem('pago')->isRequired()->isBool();

        $clienteLoja = ClienteLojaService::getClienteLoja($loja->getId(), $cliente->getId()) ?: null;
        $configLoja = ConfigService::getConfigByLoja($loja->getId()) ?: null;
        $maxCredit = $clienteLoja?->getMaxCredit() ?: $configLoja?->getMaxCredit();
        $totalPendente = CompraService::getTotalCliente($loja->getId(), $cliente->getId(), 0, new \DateTime, false);

        $this->setItem('credito', $total + $totalPendente);

        $this->getItem('credito')->isMaxValue($maxCredit)->isNumeric();
    }
}