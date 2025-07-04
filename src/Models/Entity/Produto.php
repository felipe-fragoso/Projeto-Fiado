<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class Produto
{
    private ?int $id;
    private Loja|LazyDataObj $loja;
    private string $name;
    private string $price;
    private string $date;
    private string $description;
    private bool $active;

    /**
     * @param $id
     * @param Loja|LazyDataObj $loja
     * @param $name
     * @param $price
     * @param $date
     * @param $description
     * @param $active
     */
    public function __construct($id, Loja | LazyDataObj $loja, $name, $price, $date, $description, $active)
    {
        $this->id = $id;
        $this->loja = $loja;
        $this->name = $name;
        $this->price = $price;
        $this->date = $date;
        $this->description = $description;
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getId()
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }
}