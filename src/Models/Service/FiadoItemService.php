<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\FiadoItemDao;
use Fiado\Models\Entity\FiadoItem;
use Fiado\Models\Validation\FiadoItemValidate;

class FiadoItemService
{
    /**
     * @var FiadoItemDao
     */
    private static $dao;

    public static function getDao()
    {
        if (!isset(self::$dao)) {
            self::$dao = new FiadoItemDao();
        }

        return self::$dao;
    }

    /**
     * @param array $arr
     */
    private static function getFiadoItemObj(array $arr)
    {
        return new FiadoItem(
            $arr['id'],
            new LazyDataObj($arr['id_fiado'], function ($id) {return CompraService::getCompra($id);}),
            new LazyDataObj($arr['id_produto'], function ($id) {return ProdutoService::getProduto($id);}),
            $arr['value'],
            $arr['quantity']
        );
    }

    /**
     * @param int $id
     */
    public static function listFiadoItem(int $id)
    {
        $arr = self::getDao()->listFiadoItem(new ParamData(new ParamItem('id_fiado', $id, \PDO::PARAM_INT)));

        if ($arr) {
            return array_map(function ($item) {return self::getFiadoItemObj($item);}, $arr);
        }

        return false;
    }

    /**
     * @param int $id
     */
    public static function getFiadoItem(int $id)
    {
        $arr = self::getDao()->getFiadoItemById(new ParamData(new ParamItem('id', $id, \PDO::PARAM_INT)));

        if ($arr) {
            return self::getFiadoItemObj($arr);
        }

        return false;
    }

    /**
     * @param $id
     * @param $idFiado
     * @param $idProduto
     * @param $value
     * @param $quantity
     * @return mixed
     */
    public static function salvar($id, $idFiado, $idProduto, $value, $quantity)
    {
        $fiado = CompraService::getCompra($idFiado) ?: null;
        $produto = ProdutoService::getProduto($idProduto) ?: null;

        $validation = new FiadoItemValidate($id, $fiado, $produto, $value, $quantity);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $fiadoItem = new FiadoItem($id, $fiado, $produto, $value, $quantity);

        if ($fiadoItem->getId()) {
            return self::getDao()->editFiadoItem([
                'id' => $fiadoItem->getId(),
                'value' => $fiadoItem->getValue(),
                'quantity' => $fiadoItem->getQuantity(),
            ]);
        }

        return self::getDao()->addFiadoItem([
            'id_fiado' => $fiadoItem->getFiado()->getId(),
            'id_produto' => $fiadoItem->getProduto()->getId(),
            'value' => $fiadoItem->getValue(),
            'quantity' => $fiadoItem->getQuantity(),
        ]);
    }
}