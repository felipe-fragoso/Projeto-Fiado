<?php

namespace Fiado\Models\Entity;

class Cliente
{
    private ?int $id;
    private string $cpf;
    private string $name;
    private string $email;
    private ?string $senha;
    private string $date;

    /**
     * @param ?int $id
     * @param string $cpf
     * @param string $name
     * @param string $email
     * @param string $senha
     * @param string $date
     */
    public function __construct(?int $id, string $cpf, string $name, string $email, ?string $senha, string $date)
    {
        $this->id = $id;
        $this->cpf = $cpf;
        $this->name = $name;
        $this->email = $email;
        $this->senha = $this->hashpassword($senha);
        $this->date = $date;
    }

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return ?string
     */
    public function getSenha(): ?string
    {
        return $this->senha;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param $password
     * @return ?string
     */
    public function hashpassword($password)
    {
        if ($password) {
            $info = password_get_info($password);

            if ($info['algo'] !== PASSWORD_DEFAULT) {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
        }

        return $password;
    }
}