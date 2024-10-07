<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ClienteDao;
use Fiado\Models\Entity\Cliente;
use Fiado\Models\Validation\ClienteValidate;

class ClienteService
{
    /**
     * @param string $email
     * @param string $password
     */
    public static function getClienteByEmail(string $email)
    {
        $dao = new ClienteDao();

        $arr = $dao->getClienteByEmail(new ParamData(new ParamItem('email', $email)));

        if ($arr) {
            return new Cliente($arr['id'], $arr['cpf'], $arr['name'], $arr['email'], $arr['senha']);
        }

        return false;
    }

    /**
     * @param string $email
     * @param string $password
     */
    public static function getLogin(string $email, $password)
    {
        $loja = self::getClienteByEmail($email);

        if ($loja) {
            return password_verify($password, $loja->getSenha());
        }

        return false;
    }

    /**
     * @param Cliente $store
     * @return mixed
     */
    public static function salvar($id, $cpf, $name, $email, $password)
    {
        $validation = new ClienteValidate($id, $cpf, $name, $email, $password);

        if ($validation->getNumErrors()) {
            return false;
        }

        $store = new Cliente($id, $cpf, $name, $email, $password);
        $dao = new ClienteDao();

        if ($store->getId()) {
            return $dao->editCliente([
                'id' => $store->getId(),
                'name' => $store->getName(),
                'cpf' => $store->getCpf(),
                'email' => $store->getEmail(),
                'senha' => $store->getSenha(),
                'date' => $store->getDate(),
            ]);
        }

        return $dao->addCliente([
            'name' => $store->getName(),
            'cpf' => $store->getCpf(),
            'email' => $store->getEmail(),
            'senha' => $store->getSenha(),
            'date' => $store->getDate(),
        ]);
    }
}