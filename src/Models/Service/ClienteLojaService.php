<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ClienteLojaDao;
use Fiado\Models\Entity\ClienteLoja;
use Fiado\Models\Validation\ClienteLojaValidate;

class ClienteLojaService
{
    /**
     * @param array $arr
     */
    private static function getClienteLojaObj(array $arr)
    {
        return new ClienteLoja(
            $arr['id'],
            new LazyDataObj($arr['id_loja'], function ($id) {return LojaService::getLojaById($id);}),
            new LazyDataObj($arr['id_cliente'], function ($id) {return ClienteService::getClienteById($id);}),
            $arr['max_credit'],
            $arr['active']
        );
    }

    /**
     * @param int $id
     */
    public static function getClienteLojaById(int $id)
    {
        $dao = new ClienteLojaDao();

        $arr = $dao->getClienteById(new ParamData(new ParamItem('id', $id)));

        if ($arr) {
            return self::getClienteLojaObj($arr);
        }

        return false;
    }

    /**
     * @param int $loja
     * @param int $cliente
     */
    public static function getClienteLoja(int $loja, int $cliente)
    {
        $dao = new ClienteLojaDao();

        $data = new ParamData(null);
        $data->addData('id_cliente', $cliente);
        $data->addData('id_loja', $loja);

        $arr = $dao->getClienteByLoja($data);

        if ($arr) {
            return self::getClienteLojaObj($arr);
        }

        return false;
    }

    /**
     * @param int $idLoja
     * @param ?string $like
     * @param ?bool $active
     * @return mixed
     */
    public static function totalClienteLoja(int $idLoja, ?string $like = null, ?bool $active = null)
    {
        $dao = new ClienteLojaDao();

        $data = new ParamData(new ParamItem('id_loja', $idLoja, \PDO::PARAM_INT));

        if ($active !== null) {
            $data->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        if ($like !== null) {
            $data->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        return $dao->countCliente("id_loja = :id_loja AND cliente_loja.id_cliente = cliente.id {$like} {$active}", $data);
    }

    /**
     * @param int $loja
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     */
    public static function listClienteLoja(int $loja, int $first, int $quantity, ?bool $active = null, ?string $like = null)
    {
        $dao = new ClienteLojaDao();

        $data = new ParamData(new ParamItem('id_loja', $loja, \PDO::PARAM_INT));
        $data->addData('first', $first, \PDO::PARAM_INT);
        $data->addData('last', $quantity, \PDO::PARAM_INT);

        if ($active !== null) {
            $data->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        if ($like !== null) {
            $data->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        $arr = $dao->listCliente(
            "id_loja = :id_loja AND cliente_loja.id_cliente = cliente.id {$active} {$like}",
            $data,
            ':first, :last',
            'cliente.date DESC'
        );

        if ($arr) {
            return array_map(function ($item) {
                return self::getClienteLojaObj($item);
            }, $arr);
        }

        return false;
    }

    /**
     * @param $id
     * @param $idLoja
     * @param $idCliente
     * @param $maxCredit
     * @param $active
     * @return mixed
     */
    public static function salvar($id, $idLoja, $idCliente, $maxCredit, $active)
    {
        $cliente = ClienteService::getClienteById($idCliente) ?: null;
        $loja = LojaService::getLojaById($idLoja) ?: null;

        $validation = new ClienteLojaValidate($id, $loja, $cliente, $maxCredit, $active);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $clienteLoja = new ClienteLoja($id, $loja, $cliente, $maxCredit, $active);
        $dao = new ClienteLojaDao();

        if ($clienteLoja->getId()) {
            return $dao->editCliente([
                'id' => $clienteLoja->getId(),
                'id_loja' => $clienteLoja->getLoja()->getId(),
                'id_cliente' => $clienteLoja->getCliente()->getId(),
                'max_credit' => $clienteLoja->getMaxCredit(),
                'active' => $clienteLoja->getActive(),
            ]);
        }

        return $dao->addCliente([
            'id_loja' => $clienteLoja->getLoja()->getId(),
            'id_cliente' => $clienteLoja->getCliente()->getId(),
            'max_credit' => $clienteLoja->getMaxCredit(),
            'active' => $clienteLoja->getActive(),
        ]);
    }
}