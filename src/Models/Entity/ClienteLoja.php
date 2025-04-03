<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class ClienteLoja
{
    private ?int $id;
    private Loja|LazyDataObj $loja;
    private Cliente|LazyDataObj $cliente;
    private ?string $maxCredit;
    private bool $active;

    /**
     * @param ?int $id
     * @param Loja|LazyDataObj $loja
     * @param Cliente|LazyDataObj $cliente
     * @param ?string $maxCredit
     * @param bool $active
     */
    public function __construct(?int $id, Loja | LazyDataObj $loja, Cliente | LazyDataObj $cliente, ?string $maxCredit, bool $active)
    {
        $this->id = $id;
        $this->loja = $loja;
        $this->cliente = $cliente;
        $this->maxCredit = $maxCredit;
        $this->active = $active;
    }

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Loja|LazyDataObj
     */
    public function getLoja(): Loja | LazyDataObj
    {
        return $this->loja;
    }

    /**
     * @return Cliente|LazyDataObj
     */
    public function getCliente(): Cliente | LazyDataObj
    {
        return $this->cliente;
    }

    /**
     * @return ?string
     */
    public function getMaxCredit(): ?string
    {
        return $this->maxCredit;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }
}