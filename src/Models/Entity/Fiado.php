<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class Fiado
{
    private ?int $id;
    private Cliente|LazyDataObj $cliente;
    private Loja|LazyDataObj $loja;
    private string $total;
    private string $date;
    private string $dueDate;
    private bool $paid;

    /**
     * @param int $id
     * @param ClienteLazyDataObj $cliente
     * @param LojaLazyDataObj $loja
     * @param string $total
     * @param string $date
     * @param string $dueDate
     * @param bool $paid
     */
    public function __construct(?int $id, Cliente | LazyDataObj $cliente, Loja | LazyDataObj $loja, string $total, string $date, string $dueDate, bool $paid)
    {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->loja = $loja;
        $this->total = $total;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->paid = $paid;
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
    public function getCliente(): Cliente | LazyDataObj
    {
        return $this->cliente;
    }

    /**
     * @return mixed
     */
    public function getLoja(): Loja | LazyDataObj
    {
        return $this->loja;
    }

    /**
     * @return mixed
     */
    public function getTotal(): string
    {
        return $this->total;
    }

    /**
     * @return mixed
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    /**
     * @return mixed
     */
    public function getPaid(): bool
    {
        return $this->paid;
    }
}