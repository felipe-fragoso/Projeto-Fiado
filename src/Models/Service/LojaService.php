<?php

namespace Fiado\Models\Service;

use Fiado\Models\Dao\LojaDao;
use Fiado\Models\Entity\Loja;
use Fiado\Models\Validation\LojaValidate;

class LojaService
{
    /**
     * @param Loja $store
     * @return mixed
     */
    public static function salvar($id, $cnpj, $name, $email, $password)
    {
        $validation = new LojaValidate($id, $cnpj, $name, $email, $password);

        if ($validation->getNumErrors()) {
            return false;
        }

        $store = new Loja($id, $cnpj, $name, $email, $password);
        $dao = new LojaDao();

        if ($store->getId()) {
            return $dao->editLoja([
                'id' => $store->getId(),
                'name' => $store->getName(),
                'cnpj' => $store->getCnpj(),
                'email' => $store->getEmail(),
                'senha' => $store->getSenha(),
                'date' => $store->getDate(),
            ]);
        }

        return $dao->addLoja([
            'name' => $store->getName(),
            'cnpj' => $store->getCnpj(),
            'email' => $store->getEmail(),
            'senha' => $store->getSenha(),
            'date' => $store->getDate(),
        ]);
    }
}