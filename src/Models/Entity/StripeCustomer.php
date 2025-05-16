<?php

namespace Fiado\Models\Entity;

class StripeCustomer
{
    private ?int $id;
    private string $idCustomer;
    private string $email;

    /**
     * @param $id
     * @param $idCustomer
     * @param $email
     */
    public function __construct($id, $idCustomer, $email)
    {
        $this->id = $id;
        $this->idCustomer = $idCustomer;
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdCustomer()
    {
        return $this->idCustomer;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
}