<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\FiadoDao;
use Fiado\Models\Entity\Fiado;
use Fiado\Models\Validation\CompraValidate;

class CompraService
{
    /**
     * @var FiadoDao
     */
    private static $dao;

    public static function getDao()
    {
        if (!isset(self::$dao)) {
            self::$dao = new FiadoDao();
        }

        return self::$dao;
    }

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
        $arr = self::getDao()->getFiadoById(new ParamData(new ParamItem('id', $id, \PDO::PARAM_INT)));

        if ($arr) {
            return self::getCompraObj($arr);
        }

        return false;
    }

    /**
     * @param int $idLoja
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     */
    public static function listCompraLoja(int $idLoja, int $first, int $quantity, ?bool $active = null, ?string $like = null)
    {
        $data = new ParamData(new ParamItem('id_loja', $idLoja, \PDO::PARAM_INT));
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

        $arr = self::getDao()->listFiado(
            "id_loja = :id_loja AND fiado.id_cliente = cliente.id {$active} {$like}",
            $data,
            ':first, :last',
            'fiado.date DESC'
        );

        if ($arr) {
            return array_map(function ($item) {return self::getCompraObj($item);}, $arr);
        }

        return false;
    }

    /**
     * @param int $idLoja
     * @param ?string $like
     * @param ?bool $active
     * @return mixed
     */
    public static function totalCompraLoja(int $idLoja, ?string $like = null, ?bool $active = null)
    {
        $data = new ParamData(new ParamItem('id_loja', $idLoja, \PDO::PARAM_INT));

        if ($active !== null) {
            $data->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        if ($like !== null) {
            $data->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        return self::getDao()->countFiado("id_loja = :id_loja AND fiado.id_cliente = cliente.id {$like} {$active}", $data);
    }

    /**
     * @param int $idLoja
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     */
    public static function listCompraPendenteLoja(int $idLoja, int $first, int $quantity, ?bool $active = null, ?string $like = null)
    {
        $paramData = new ParamData(null);
        $paramData->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $paramData->addData('paid', false, \PDO::PARAM_INT);
        $paramData->addData('first', $first, \PDO::PARAM_INT);
        $paramData->addData('last', $quantity, \PDO::PARAM_INT);

        if ($active !== null) {
            $paramData->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        if ($like !== null) {
            $paramData->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        $arr = self::getDao()->listFiadoPendente(
            "id_loja = :id_loja AND paid = :paid AND fiado.id_cliente = cliente.id {$like} {$active}",
            $paramData,
            ':first, :last',
            'fiado.date DESC'
        );

        if ($arr) {
            return array_map(function ($item) {return self::getCompraObj($item);}, $arr);
        }

        return false;
    }

    /**
     * @param int $idLoja
     * @param ?string $like
     * @param ?bool $active
     * @return mixed
     */
    public static function totalCompraPendenteLoja(int $idLoja, ?string $like = null, ?bool $active = null)
    {
        $paramData = new ParamData(null);
        $paramData->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $paramData->addData('paid', false, \PDO::PARAM_INT);

        if ($active !== null) {
            $paramData->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        if ($like !== null) {
            $paramData->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        return self::getDao()->countFiadoPendente("id_loja = :id_loja AND paid = :paid AND fiado.id_cliente = cliente.id {$like} {$active}", $paramData);
    }

    /**
     * @param int $idLoja
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     */
    public static function listCompraVencidaLoja(int $idLoja, int $first, int $quantity, ?bool $active = null, ?string $like = null)
    {
        $paramData = new ParamData(null);
        $paramData->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $paramData->addData('paid', false, \PDO::PARAM_INT);
        $paramData->addData('first', $first, \PDO::PARAM_INT);
        $paramData->addData('last', $quantity, \PDO::PARAM_INT);
        $paramData->addData('due_date', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);

        if ($like !== null) {
            $paramData->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        $arr = self::getDao()->listFiadoPendente(
            "id_loja = :id_loja AND paid = :paid AND due_date < :due_date AND fiado.id_cliente = cliente.id {$like} {$active}",
            $paramData,
            ':first, :last',
            'fiado.date DESC'
        );

        if ($arr) {
            return array_map(function ($item) {return self::getCompraObj($item);}, $arr);
        }

        return false;
    }

    /**
     * @param int $idLoja
     * @param ?string $like
     * @return mixed
     */
    public static function totalCompraVencidaLoja(int $idLoja, ?string $like = null)
    {
        $paramData = new ParamData(null);
        $paramData->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $paramData->addData('paid', false, \PDO::PARAM_INT);
        $paramData->addData('due_date', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);

        if ($like !== null) {
            $paramData->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        return self::getDao()->countFiadoPendente(
            "id_loja = :id_loja AND paid = :paid AND due_date < :due_date AND fiado.id_cliente = cliente.id {$like}",
            $paramData
        );
    }

    /**
     * @param int $loja
     * @param \DateTime|int $from
     * @return mixed
     */
    public static function getTotalVencido(int $loja, \DateTime  | int $from = 0)
    {
        $data = new ParamData(null);

        if (is_int($from)) {
            $from = \DateTime::createFromFormat('U', $from);
        }

        $data->addData('id_loja', $loja, \PDO::PARAM_INT);
        $data->addData('paid', false, \PDO::PARAM_INT);
        $data->addData('from', $from->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $data->addData('due_date', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);

        return self::getDao()->totalVencido($data);
    }

    /**
     * @param int $idLoja
     * @param int $idCliente
     */
    public static function listCompraLojaCliente(int $idLoja, int $idCliente)
    {
        $paramData = new ParamData(null);
        $paramData->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $paramData->addData('id_cliente', $idCliente, \PDO::PARAM_INT);

        $arr = self::getDao()->listFiadoCliente($paramData);

        if ($arr) {
            return array_map(function ($item) {return self::getCompraObj($item);}, $arr);
        }

        return false;
    }

    /**
     * @param int $loja
     * @param \DateTime|int $start
     * @param \DateTime $end
     * @param ?bool $paid
     * @return mixed
     */
    public static function getTotal(int $loja, \DateTime  | int $start, \DateTime $end = new \DateTime(), ?bool $paid = null)
    {
        $data = new ParamData(null);

        if ($start instanceof \DateTime) {
            $data->addData('start', $start->format('Y-m-d H:i:s'));
        } else {
            $data->addData('start', $start, \PDO::PARAM_INT);
        }

        $data->addData('end', $end->format('Y-m-d H:i:s'));
        $data->addData('id_loja', $loja, \PDO::PARAM_INT);
        $data->addData('paid', $paid);

        return self::getDao()->total($data);
    }

    /**
     * @param int $idLoja
     * @param int $idCliente
     * @param \DateTime|int $start
     * @param \DateTime $end
     * @param ?bool $paid
     * @return mixed
     */
    public static function getTotalCliente(int $idLoja, int $idCliente, \DateTime  | int $start, \DateTime $end = new \DateTime(), ?bool $paid = null)
    {
        $data = new ParamData(null);

        if ($start instanceof \DateTime) {
            $data->addData('start', $start->format('Y-m-d H:i:s'));
        } else {
            $data->addData('start', $start, \PDO::PARAM_INT);
        }

        $data->addData('end', $end->format('Y-m-d H:i:s'));
        $data->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $data->addData('id_cliente', $idCliente, \PDO::PARAM_INT);
        $data->addData('paid', $paid);

        return self::getDao()->totalCliente($data);
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
    public static function salvar($id, $idCliente, $idLoja, $total, $date, $dueDate, $paid)
    {
        $cliente = ClienteService::getClienteById($idCliente) ?: null;
        $loja = LojaService::getLojaById($idLoja) ?: null;

        $validation = new CompraValidate($id, $cliente, $loja, $total, $date, $dueDate, $paid);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $compra = new Fiado($id, $cliente, $loja, $total, $date, $dueDate, $paid);

        if ($compra->getId()) {
            return self::getDao()->editFiado([
                'id' => $compra->getId(),
                'due_date' => $compra->getDueDate(),
                'paid' => $compra->getPaid(),
            ]);
        }

        return self::getDao()->addFiado([
            'id_cliente' => $compra->getCliente()->getId(),
            'id_loja' => $compra->getLoja()->getId(),
            'total' => $compra->getTotal(),
            'date' => $compra->getDate(),
            'due_date' => $compra->getDueDate(),
            'paid' => $compra->getPaid(),
        ]);
    }
}