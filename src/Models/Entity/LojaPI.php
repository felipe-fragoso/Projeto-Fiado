<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class LojaPI
{
    private ?int $id;
    private Loja|LazyDataObj $loja;
    private string $address;
    private string $telephone;
    private string $description;
    private string $established;
    private string $openHour;
    private string $closeHour;

    /**
     * @param ?int $id
     * @param Loja|LazyDataObj $loja
     * @param string $address
     * @param string $telephone
     * @param string $description
     * @param string $established
     * @param string $openHour
     * @param string $closeHour
     */
    public function __construct(
        ?int $id,
        Loja | LazyDataObj $loja,
        string $address,
        string $telephone,
        string $description,
        string $established,
        string $openHour,
        string $closeHour
    ) {
        $this->id = $id;
        $this->loja = $loja;
        $this->address = $address;
        $this->telephone = $telephone;
        $this->description = $description;
        $this->established = $established;
        $this->openHour = $openHour;
        $this->closeHour = $closeHour;
    }

    /**
     * @return mixed
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
     * @return mixed
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @return mixed
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getEstablished(): string
    {
        return $this->established;
    }

    /**
     * @return mixed
     */
    public function getOpenHour(): string
    {
        return $this->openHour;
    }

    /**
     * @return mixed
     */
    public function getCloseHour(): string
    {
        return $this->closeHour;
    }
}