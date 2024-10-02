<?php

namespace Fiado\Models\Entity;

class Cliente
{
    private ?int $id;
    private int $cpf;
    private string $name;
    private string $email;
    private string $senha;
    private string $date;

    /**
     * @param int $id
     * @param string $cpf
     * @param string $name
     * @param string $email
     * @param string $senha
     */
    public function __construct(?int $id, string $cpf, string $name, string $email, string $senha)
    {
        $this->id = $id;
        $this->cpf = $cpf;
        $this->name = $name;
        $this->email = $email;
        $this->senha = $this->hashpassword($senha);
        $this->date = date('Y-m-d H:i:s');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCpf(): int
    {
        return $this->cpf;
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