<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class ClienteLoja
{
    private ?int $id;
    private Loja|LazyDataObj $loja;
    private Cliente|LazyDataObj $cliente;
    private ?int $maxCredit;
    private bool $active;

    public function __construct(?int $id, Loja|LazyDataObj $loja, Cliente|LazyDataObj $cliente, ?int $maxCredit, bool $active)
    {
        $this->id = $id;
        $this->loja = $loja;
        $this->cliente = $cliente;
        $this->maxCredit = $maxCredit;
        $this->active = $active;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoja(): Loja|LazyDataObj
    {
        return $this->loja;
    }

    public function getCliente(): Cliente|LazyDataObj
    {
        return $this->cliente;
    }

    public function getMaxCredit(): ?int
    {
        return $this->maxCredit;
    }

    public function getActive(): bool
    {
        return $this->active;
    }
}