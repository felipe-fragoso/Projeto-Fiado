<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class ClientePI
{
    private ?int $id;
    private Cliente|LazyDataObj $cliente;
    private string $address;
    private string $telephone;
    private ?string $description;

    /**
     * @param int $id
     * @param Cliente|LazyDataObj $cliente
     * @param string $address
     * @param string $telephone
     * @param string $description
     */
    public function __construct(?int $id, Cliente|LazyDataObj $cliente, string $address, string $telephone, ?string $description)
    {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->address = $address;
        $this->telephone = $telephone;
        $this->description = $description;
    }

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Cliente
     */
    public function getCliente(): Cliente|LazyDataObj
    {
        return $this->cliente;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}