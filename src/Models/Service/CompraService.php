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
     * @param string $fromId
     * @param int $id
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     * @param ?bool $paid
     * @param ?bool $overdue
     */
    private static function listCompra(
        string $fromId,
        int $id,
        int $first,
        int $quantity,
        ?bool $active,
        ?string $like,
        ?bool $paid = null,
        ?bool $overdue = null
    ) {
        $data = new ParamData(null);
        $data->addData($fromId, $id, \PDO::PARAM_INT);
        $data->addData('first', $first, \PDO::PARAM_INT);
        $data->addData('last', $quantity, \PDO::PARAM_INT);

        if ($overdue !== null && $paid == false) {
            $data->addData('due_date', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $overdue = "AND due_date " . ($overdue ? '<' : '>') . " :due_date";
        }

        if ($paid !== null) {
            $data->addData('paid', $paid, \PDO::PARAM_INT);
            $paid = "AND paid = :paid";
        }

        if ($active !== null) {
            $data->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        if ($like !== null) {
            $data->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        $arr = self::getDao()->listFiado(
            "{$fromId} = :{$fromId} AND fiado.id_cliente = cliente.id {$paid} {$overdue} {$active} {$like}",
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
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     */
    public static function listCompraLoja(int $idLoja, int $first, int $quantity, ?bool $active = null, ?string $like = null)
    {
        return self::listCompra('id_loja', $idLoja, $first, $quantity, $active, $like);
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
        return self::listCompra('id_loja', $idLoja, $first, $quantity, $active, $like, false);
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
        return self::listCompra('id_loja', $idLoja, $first, $quantity, $active, $like, false, true);
    }

    /**
     * @param int $idCliente
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     */
    public static function listCompraCliente(int $idCliente, int $first, int $quantity, ?bool $active = null, ?string $like = null)
    {
        return self::listCompra('id_cliente', $idCliente, $first, $quantity, $active, $like);
    }

    /**
     * @param int $idCliente
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     */
    public static function listCompraPendenteCliente(int $idCliente, int $first, int $quantity, ?bool $active = null, ?string $like = null)
    {
        return self::listCompra('id_cliente', $idCliente, $first, $quantity, $active, $like, false);
    }

    /**
     * @param int $idCliente
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     */
    public static function listCompraVencidaCliente(int $idCliente, int $first, int $quantity, ?bool $active = null, ?string $like = null)
    {
        return self::listCompra('id_cliente', $idCliente, $first, $quantity, $active, $like, false, true);
    }

    /**
     * @param int $idLoja
     * @param int $idCliente
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?bool $paid
     * @param ?bool $overdue
     */
    public static function listCompraLojaCliente(
        int $idLoja,
        int $idCliente,
        int $first,
        int $quantity,
        ?bool $active,
        ?bool $paid = null,
        ?bool $overdue = null
    ) {
        $paramData = new ParamData(null);
        $paramData->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $paramData->addData('id_cliente', $idCliente, \PDO::PARAM_INT);
        $paramData->addData('first', $first, \PDO::PARAM_INT);
        $paramData->addData('last', $quantity, \PDO::PARAM_INT);

        if ($overdue !== null && $paid == false) {
            $paramData->addData('due_date', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $overdue = "AND due_date " . ($overdue ? '<' : '>') . " :due_date";
        }

        if ($paid !== null) {
            $paramData->addData('paid', $paid, \PDO::PARAM_INT);
            $paid = "AND paid = :paid";
        }

        if ($active !== null) {
            $paramData->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        $arr = self::getDao()->listFiado(
            "id_loja = :id_loja AND id_cliente = :id_cliente AND fiado.id_cliente = cliente.id {$paid} {$overdue} {$active}",
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
     * @param string $fromId
     * @param int $id
     * @param ?string $like
     * @param ?bool $active
     * @param ?bool $paid
     * @param ?bool $overdue
     */
    private static function totalCompra(
        string $fromId,
        int $id,
        ?string $like,
        ?bool $active,
        ?bool $paid = null,
        ?bool $overdue = null
    ) {
        $data = new ParamData(null);
        $data->addData($fromId, $id, \PDO::PARAM_INT);

        if ($overdue !== null && $paid == false) {
            $data->addData('due_date', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $overdue = "AND due_date " . ($overdue ? '<' : '>') . " :due_date";
        }

        if ($paid !== null) {
            $data->addData('paid', $paid, \PDO::PARAM_INT);
            $paid = "AND paid = :paid";
        }

        if ($active !== null) {
            $data->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        if ($like !== null) {
            $data->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        return self::getDao()->countFiado("{$fromId} = :{$fromId} AND fiado.id_cliente = cliente.id {$paid} {$overdue} {$like} {$active}", $data);
    }

    /**
     * @param int $idLoja
     * @param ?string $like
     * @param ?bool $active
     */
    public static function totalCompraLoja(int $idLoja, ?string $like = null, ?bool $active = null)
    {
        return self::totalCompra('id_loja', $idLoja, $like, $active);
    }

    /**
     * @param int $idLoja
     * @param ?string $like
     * @param ?bool $active
     */
    public static function totalCompraPendenteLoja(int $idLoja, ?string $like = null, ?bool $active = null)
    {
        return self::totalCompra('id_loja', $idLoja, $like, $active, false);
    }

    /**
     * @param int $idLoja
     * @param ?string $like
     * @param ?bool $active
     */
    public static function totalCompraVencidaLoja(int $idLoja, ?string $like = null, ?bool $active = null)
    {
        return self::totalCompra('id_loja', $idLoja, $like, $active, false, true);
    }

    /**
     * @param int $idCliente
     * @param ?string $like
     * @param ?bool $active
     */
    public static function totalCompraCliente(int $idCliente, ?string $like = null, ?bool $active = null)
    {
        return self::totalCompra('id_cliente', $idCliente, $like, $active);
    }

    /**
     * @param int $idCliente
     * @param ?string $like
     * @param ?bool $active
     */
    public static function totalCompraPendenteCliente(int $idCliente, ?string $like = null, ?bool $active = null)
    {
        return self::totalCompra('id_cliente', $idCliente, $like, $active, false);
    }

    /**
     * @param int $idCliente
     * @param ?string $like
     * @param ?bool $active
     */
    public static function totalCompraVencidaCliente(int $idCliente, ?string $like = null, ?bool $active = null)
    {
        return self::totalCompra('id_cliente', $idCliente, $like, $active, false, true);
    }

    /**
     * @param int $idLoja
     * @param int $idCliente
     * @param ?bool $active
     * @param ?bool $paid
     * @param ?bool $overdue
     */
    public static function totalCompraLojaCliente(
        int $idLoja,
        int $idCliente,
        ?bool $active,
        ?bool $paid = null,
        ?bool $overdue = null
    ) {
        $data = new ParamData(null);
        $data->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $data->addData('id_cliente', $idCliente, \PDO::PARAM_INT);

        if ($overdue !== null && $paid == false) {
            $data->addData('due_date', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $overdue = "AND due_date " . ($overdue ? '<' : '>') . " :due_date";
        }

        if ($paid !== null) {
            $data->addData('paid', $paid, \PDO::PARAM_INT);
            $paid = "AND paid = :paid";
        }

        if ($active !== null) {
            $data->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        return self::getDao()->countFiado(
            "id_loja = :id_loja AND id_cliente = :id_cliente AND fiado.id_cliente = cliente.id {$paid} {$overdue} {$active}",
            $data
        );
    }

    /**
     * @param string $fromId
     * @param int $id
     * @param \DateTime|int $start
     * @param \DateTime $end
     * @param ?bool $paid
     * @param ?bool $overdue
     */
    private static function getTotal(
        string $fromId,
        int $id,
        \DateTime | int $start,
        \DateTime $end,
        ?bool $paid = null,
        ?bool $overdue = null
    ) {
        $data = new ParamData(null);

        $data->addData($fromId, $id, \PDO::PARAM_INT);
        $data->addData('end', $end->format('Y-m-d H:i:s'));

        if ($start instanceof \DateTime) {
            $data->addData('start', $start->format('Y-m-d H:i:s'));
        } else {
            $data->addData('start', $start, \PDO::PARAM_INT);
        }

        if ($overdue !== null && $paid == false) {
            $data->addData('due_date', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $overdue = "AND due_date " . ($overdue ? '<' : '>') . " :due_date";
        }

        if ($paid !== null) {
            $data->addData('paid', $paid, \PDO::PARAM_INT);
            $paid = "AND paid = :paid";
        }

        return self::getDao()->total("{$fromId} = :{$fromId} {$paid} {$overdue} AND date BETWEEN :start AND :end", $data);
    }

    /**
     * @param int $idLoja
     * @param \DateTime|int $start
     * @param \DateTime $end
     * @param ?bool $paid
     * @param ?bool $overdue
     */
    public static function getTotalLoja(
        int $idLoja,
        \DateTime | int $start,
        \DateTime $end = new \DateTime(),
        ?bool $paid = null,
        ?bool $overdue = null
    ) {
        return self::getTotal('id_loja', $idLoja, $start, $end, $paid, $overdue);
    }

    /**
     * @param int $idCliente
     * @param \DateTime|int $start
     * @param \DateTime $end
     * @param ?bool $paid
     * @param ?bool $overdue
     */
    public static function getTotalCliente(
        int $idCliente,
        \DateTime | int $start,
        \DateTime $end = new \DateTime(),
        ?bool $paid = null,
        ?bool $overdue = null
    ) {
        return self::getTotal('id_cliente', $idCliente, $start, $end, $paid, $overdue);
    }

    /**
     * @param int $idLoja
     * @param int $idCliente
     * @param \DateTime|int $start
     * @param \DateTime $end
     * @param ?bool $paid
     * @param ?bool $overdue
     */
    public static function getTotalClienteLoja(
        int $idLoja,
        int $idCliente,
        \DateTime | int $start,
        \DateTime $end = new \DateTime(),
        ?bool $paid = null,
        ?bool $overdue = null
    ) {
        $data = new ParamData(null);

        if ($start instanceof \DateTime) {
            $data->addData('start', $start->format('Y-m-d H:i:s'));
        } else {
            $data->addData('start', $start, \PDO::PARAM_INT);
        }

        $data->addData('end', $end->format('Y-m-d H:i:s'));
        $data->addData('id_loja', $idLoja, \PDO::PARAM_INT);
        $data->addData('id_cliente', $idCliente, \PDO::PARAM_INT);

        if ($overdue !== null && $paid == false) {
            $data->addData('due_date', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $overdue = "AND due_date " . ($overdue ? '<' : '>') . " :due_date";
        }

        if ($paid !== null) {
            $data->addData('paid', $paid, \PDO::PARAM_INT);
            $paid = "AND paid = :paid";
        }

        return self::getDao()->total("id_loja = :id_loja AND id_cliente = :id_cliente {$paid} {$overdue} AND date BETWEEN :start AND :end", $data);
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

    /**
     * @param $idFiado
     */
    public static function pay($idFiado)
    {
        $compra = CompraService::getCompra($idFiado);

        return self::getDao()->editFiado([
            'id' => $compra->getId(),
            'paid' => true,
        ]);
    }
}