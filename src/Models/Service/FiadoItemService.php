<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\FiadoItemDao;
use Fiado\Models\Entity\FiadoItem;
use Fiado\Models\Validation\FiadoItemValidate;

class FiadoItemService
{
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
        $dao = new FiadoItemDao();

        $arr = $dao->listFiadoItem(new ParamData(new ParamItem('id_fiado', $id, \PDO::PARAM_INT)));

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
        $dao = new FiadoItemDao();

        $arr = $dao->getFiadoItemById(new ParamData(new ParamItem('id', $id, \PDO::PARAM_INT)));

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
        $fiado = CompraService::getCompra($idFiado);
        $produto = ProdutoService::getProduto($idProduto);

        $validation = new FiadoItemValidate($fiado, $produto, $value, $quantity);

        if ($validation->getNumErrors()) {
            return false;
        }

        $fiadoItem = new FiadoItem($id, $fiado, $produto, $value, $quantity);

        $dao = new FiadoItemDao();

        if ($fiadoItem->getId()) {
            return $dao->editFiadoItem([
                'id' => $fiadoItem->getId(),
                'value' => $fiadoItem->getValue(),
                'quantity' => $fiadoItem->getQuantity(),
            ]);
        }

        return $dao->addFiadoItem([
            'id_fiado' => $fiadoItem->getFiado()->getId(),
            'id_produto' => $fiadoItem->getProduto()->getId(),
            'value' => $fiadoItem->getValue(),
            'quantity' => $fiadoItem->getQuantity(),
        ]);
    }
}