<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ProdutoDao;
use Fiado\Models\Entity\Produto;
use Fiado\Models\Validation\ProdutoValidate;

class ProdutoService
{
    /**
     * @param array $arr
     */
    public static function getProdutoObj(array $arr)
    {
        return new Produto(
            $arr['id'],
            new LazyDataObj($arr['id_loja'], function ($id) {return LojaService::getLojaById($id);}),
            $arr['name'],
            $arr['price'],
            $arr['date'],
            $arr['description'],
            $arr['active']
        );
    }

    /**
     * @param int $id
     */
    public static function getProduto(int $id)
    {
        $dao = new ProdutoDao();

        $arr = $dao->getProduto(new ParamData(new ParamItem('id', $id, \PDO::PARAM_INT)));

        if ($arr) {
            return self::getProdutoObj($arr);
        }

        return false;
    }

    /**
     * @param $first
     * @param $quantity
     * @return mixed
     */
    public static function listProduto($first, $quantity)
    {
        $dao = new ProdutoDao();

        $data = new ParamData(new ParamItem('first', $first, \PDO::PARAM_INT));
        $data->addData('last', $quantity, \PDO::PARAM_INT);

        $arr = $dao->listProduto('1=1 LIMIT :first, :last', $data);

        if ($arr) {
            return array_map(function ($item) {return self::getProdutoObj($item);}, $arr);
        }

        return false;
    }

    /**
     * @param $text
     * @param $quantity
     * @return mixed
     */
    public static function listProdutoWith($text, $quantity)
    {
        $dao = new ProdutoDao();

        $data = new ParamData(new ParamItem('name', "%$text%"));
        $data->addData('quantity', $quantity, \PDO::PARAM_INT);

        $arr = $dao->listProduto('name LIKE :name LIMIT 0, :quantity', $data);

        if ($arr) {
            return array_map(function ($item) {return self::getProdutoObj($item);}, $arr);
        }

        return false;
    }

    /**
     * @param $id
     * @param $name
     * @param $price
     * @param $active
     * @param $description
     * @return mixed
     */
    public static function salvar($id, $idLoja, $name, $price, $active, $description)
    {
        $loja = LojaService::getLojaById($idLoja);

        $validation = new ProdutoValidate($name, $loja, $price, $active, $description);

        if ($validation->getNumErrors()) {
            return false;
        }

        $date = date('Y-m-d H:i:s');

        $produto = new Produto($id, $loja, $name, $price, $date, $description, $active);
        $dao = new ProdutoDao();

        if ($produto->getId()) {
            return $dao->editProduto([
                'id' => $produto->getId(),
                'name' => $produto->getName(),
                'price' => $produto->getPrice(),
                'description' => $produto->getDescription(),
                'active' => $produto->getActive(),
            ]);
        }

        return $dao->addProduto([
            'id_loja' => $produto->getLoja()->getId(),
            'name' => $produto->getName(),
            'price' => $produto->getPrice(),
            'date' => $produto->getDate(),
            'description' => $produto->getDescription(),
            'active' => $produto->getActive(),
        ]);
    }
}