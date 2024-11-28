<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\FiadoDao;
use Fiado\Models\Entity\Fiado;
use Fiado\Models\Validation\CompraValidate;

class CompraService
{
    /**
     * @param array $arr
     */
    private static function getCompraObj(array $arr)
    {
        return new Fiado(
            $arr['id'],
            new LazyDataObj($arr['id_cliente'], function ($id) {return ClienteService::getClienteById($id);}),
            new LazyDataObj($arr['id_loja'], function ($id) {return LojaService::getLojaById($id);}),
            $arr['total'],
            $arr['date'],
            $arr['due_date'],
            $arr['paid']
        );
    }

    /**
     * @param int $id
     */
    public static function getCompra(int $id)
    {
        $dao = new FiadoDao();

        $arr = $dao->getFiadoById(new ParamData(new ParamItem('id', $id, \PDO::PARAM_INT)));

        if ($arr) {
            return self::getCompraObj($arr);
        }

        return false;
    }

    /**
     * @param int $idLoja
     */
    public static function listCompraLoja(int $idLoja)
    {
        $dao = new FiadoDao();

        $arr = $dao->listFiado(new ParamData(new ParamItem('id_loja', $idLoja, \PDO::PARAM_INT)));

        if ($arr) {
            return array_map(function ($item) {return self::getCompraObj($item);}, $arr);
        }
    }

    /**
     * @param int $idLoja
     */
    public static function listCompraPendenteLoja(int $idLoja)
    {
        $dao = new FiadoDao();

        $paramData = new ParamData(null);
        $paramData->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $paramData->addData('paid', false, \PDO::PARAM_INT);

        $arr = $dao->listFiadoPendente($paramData);

        if ($arr) {
            return array_map(function ($item) {return self::getCompraObj($item);}, $arr);
        }
    }

    /**
     * @param int $loja
     * @param \DateTime|int $start
     * @param \DateTime $end
     * @param \DateTimebool $paid
     * @return mixed
     */
    public static function getTotal(int $loja, \DateTime  | int $start, \DateTime $end = new \DateTime(), bool $paid = null)
    {
        $dao = new FiadoDao();
        $data = new ParamData(null);

        if ($start instanceof \DateTime) {
            $data->addData('start', $start->format('Y-m-d H:i:s'));
        } else {
            $data->addData('start', $start, \PDO::PARAM_INT);
        }

        $data->addData('end', $end->format('Y-m-d H:i:s'));
        $data->addData('id_loja', $loja, \PDO::PARAM_INT);
        $data->addData('paid', $paid);

        return $dao->total($data);
    }

    /**
     * @param $id
     * @param $cliente
     * @param $loja
     * @param $total
     * @param $date
     * @param $dueDate
     * @param $paid
     * @return mixed
     */
    public static function salvar($id, $cliente, $loja, $total, $date, $dueDate, $paid)
    {
        $cliente = ClienteService::getClienteById($cliente);
        $loja = LojaService::getLojaById($loja);

        $validation = new CompraValidate($cliente, $loja, $total, $date, $dueDate, $paid);

        if ($validation->getNumErrors()) {
            return false;
        }

        $compra = new Fiado($id, $cliente, $loja, $total, $date, $dueDate, $paid);
        $dao = new FiadoDao();

        if ($compra->getId()) {
            return $dao->editFiado([
                'id' => $compra->getId(),
                'due_date' => $compra->getDueDate(),
                'paid' => $compra->getPaid(),
            ]);
        }

        return $dao->addFiado([
            'id_cliente' => $compra->getCliente()->getId(),
            'id_loja' => $compra->getLoja()->getId(),
            'total' => $compra->getTotal(),
            'date' => $compra->getDate(),
            'due_date' => $compra->getDueDate(),
            'paid' => $compra->getPaid(),
        ]);
    }
}