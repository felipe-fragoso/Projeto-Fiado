<?php

namespace Fiado\Models\Service;

use Fiado\Models\Dao\ClienteDao;
use Fiado\Models\Entity\Cliente;
use Fiado\Models\Validation\ClienteValidate;

class ClienteService
{
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