<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ClienteDao;
use Fiado\Models\Entity\Cliente;
use Fiado\Models\Validation\ClienteValidate;

class ClienteService
{
    /**
     * @param array $arr
     */
    private static function getClienteObj(array $arr)
    {
        return new Cliente($arr['id'], $arr['cpf'], $arr['name'], $arr['email'], $arr['senha'], $arr['date']);
    }

    /**
     * @param int $id
     */
    public static function getClienteById(int $id)
    {
        $dao = new ClienteDao();

        $arr = $dao->getClienteById(new ParamData(new ParamItem('id', $id)));

        if ($arr) {
            return self::getClienteObj($arr);
        }

        return false;
    }

    /**
     * @param string $email
     */
    public static function getClienteByEmail(string $email)
    {
        $dao = new ClienteDao();

        $arr = $dao->getClienteByEmail(new ParamData(new ParamItem('email', $email)));

        if ($arr) {
            return self::getClienteObj($arr);
        }

        return false;
    }

    /**
     * @param $id
     * @param $cpf
     * @param $name
     * @param $email
     * @param $password
     * @return mixed
     */
    public static function salvar($id, $cpf, $name, $email, $password, $conPassword, $date = null)
    {
        $date = $date ?? date('Y-m-d H:i:s');

        $validation = new ClienteValidate($id, $cpf, $name, $email, $password, $conPassword, $date);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $store = new Cliente($id, $cpf, $name, $email, $password, $date);
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