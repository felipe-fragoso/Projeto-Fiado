<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ClientePIDao;
use Fiado\Models\Entity\ClientePI;
use Fiado\Models\Validation\ClientePIValidate;

class ClientePIService
{
    /**
     * @param array $arr
     */
    private static function getClientePIObj(array $arr)
    {
        return new ClientePI(
            $arr['id'],
            new LazyDataObj($arr['id'], function ($id) {return ClienteService::getClienteById($id);}),
            $arr['address'],
            $arr['telephone'],
            $arr['description']
        );
    }

    /**
     * @param int $id
     */
    public static function getClientePI(int $id)
    {
        $dao = new ClientePIDao();

        $arr = $dao->getClientePI(new ParamData(new ParamItem('id_cliente', $id)));

        if ($arr) {
            return self::getClientePIObj($arr);
        }

        return false;
    }

    /**
     * @param $id
     * @param $idCliente
     * @param $address
     * @param $telephone
     * @param $description
     * @return mixed
     */
    public static function salvar($id, $idCliente, $address, $telephone, $description)
    {
        $cliente = ClienteService::getClienteById($idCliente) ?: null;

        $validation = new ClientePIValidate($id, $cliente, $address, $telephone, $description);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $clientePI = new ClientePI($id, $cliente, $address, $telephone, $description);
        $dao = new ClientePIDao();

        if ($clientePI->getId()) {
            return $dao->editCliente([
                'id' => $clientePI->getId(),
                'id_cliente' => $clientePI->getCliente()->getId(),
                'address' => $clientePI->getAddress(),
                'telephone' => $clientePI->getTelephone(),
                'description' => $clientePI->getDescription(),
            ]);
        }

        return $dao->addCliente([
            'id_cliente' => $clientePI->getCliente()->getId(),
            'address' => $clientePI->getAddress(),
            'telephone' => $clientePI->getTelephone(),
            'description' => $clientePI->getDescription(),
        ]);
    }
}