<?php

namespace Fiado\Models\Entity;

class Loja
{
    private ?int $id;
    private int $cnpj;
    private string $name;
    private string $email;
    private string $senha;
    private string $date;

    /**
     * @param int $id
     * @param string $cnpj
     * @param string $name
     * @param string $email
     * @param string $senha
     */
    public function __construct(?int $id, string $cnpj, string $name, string $email, string $senha)
    {
        $this->id = $id;
        $this->cnpj = $cnpj;
        $this->name = $name;
        $this->email = $email;
        $this->senha = $this->hashpassword($senha);
        $this->date = date('Y-m-d H:i:s');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCnpj(): int
    {
        return $this->cnpj;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function hashpassword($password)
    {
        $info = password_get_info($password);

        if ($info['algo'] !== PASSWORD_DEFAULT) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        return $password;
    }
}