<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class FiadoItem
{
    private ?int $id;
    private Fiado|LazyDataObj $fiado;
    private Produto|LazyDataObj $produto;
    private string $value;
    private int $quantity;

    /**
     * @param int $id
     * @param FiadoLazyDataObj $fiado
     * @param ProdutoLazyDataObj $produto
     * @param string $value
     * @param int $quantity
     */
    public function __construct(?int $id, Fiado | LazyDataObj $fiado, Produto | LazyDataObj $produto, string $value, int $quantity)
    {
        $this->id = $id;
        $this->fiado = $fiado;
        $this->produto = $produto;
        $this->value = $value;
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFiado(): Fiado | LazyDataObj
    {
        return $this->fiado;
    }

    /**
     * @return mixed
     */
    public function getProduto(): Produto | LazyDataObj
    {
        return $this->produto;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}