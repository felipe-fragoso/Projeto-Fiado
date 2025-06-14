<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class ClienteCompletionLink
{
    private ?int $id;
    private string $hash;
    private Cliente|LazyDataObj $cliente;
    private Loja|LazyDataObj $loja;
    private bool $used;
    private string $validUntil;

    /**
     * @param ?int $id
     * @param string $hash
     * @param Cliente|LazyDataObj $cliente
     * @param Loja|LazyDataObj $loja
     * @param bool $used
     * @param string $validUntil
     */
    public function __construct(
        ?int $id,
        string $hash,
        Cliente | LazyDataObj $cliente,
        Loja | LazyDataObj $loja,
        bool $used,
        string $validUntil
    ) {
        $this->id = $id;
        $this->hash = $hash;
        $this->cliente = $cliente;
        $this->loja = $loja;
        $this->used = $used;
        $this->validUntil = $validUntil;
    }

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return Cliente
     */
    public function getCliente(): Cliente | LazyDataObj
    {
        return $this->cliente;
    }

    /**
     * @return Loja
     */
    public function getLoja(): Loja | LazyDataObj
    {
        return $this->loja;
    }

    /**
     * @return bool
     */
    public function getUsed(): bool
    {
        return $this->used;
    }

    /**
     * @return string
     */
    public function getValidUntil(): string
    {
        return $this->validUntil;
    }
}