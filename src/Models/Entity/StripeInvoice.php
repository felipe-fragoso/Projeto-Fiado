<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class StripeInvoice
{
    private ?int $id;
    private Fiado|LazyDataObj $fiado;
    private string $idInvoice;

    /**
     * @param $id
     * @param Fiado|LazyDataObj $fiado
     * @param $idInvoice
     */
    public function __construct($id, Fiado | LazyDataObj $fiado, $idInvoice)
    {
        $this->id = $id;
        $this->fiado = $fiado;
        $this->idInvoice = $idInvoice;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Fiado|LazyDataObj
     */
    public function getFiado(): Fiado | LazyDataObj
    {
        return $this->fiado;
    }

    /**
     * @return mixed
     */
    public function getIdInvoice()
    {
        return $this->idInvoice;
    }
}