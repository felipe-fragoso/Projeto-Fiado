<?php

namespace Fiado\Models\Entity;

use Fiado\Helpers\LazyDataObj;

class Config
{
    private ?int $id;
    private Loja|LazyDataObj $loja;
    private string $payLimit;
    private string $maxCredit;

    /**
     * @param int $id
     * @param Loja|LazyDataObj $loja
     * @param string $payLimit
     * @param int $maxCredit
     */
    public function __construct(?int $id, Loja | LazyDataObj $loja, string $payLimit, string $maxCredit)
    {
        $this->id = $id;
        $this->loja = $loja;
        $this->payLimit = $payLimit;
        $this->maxCredit = $maxCredit;
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
    public function getPayLimit(): string
    {
        return $this->payLimit;
    }

    /**
     * @return mixed
     */
    public function getMaxCredit(): string
    {
        return $this->maxCredit;
    }
}