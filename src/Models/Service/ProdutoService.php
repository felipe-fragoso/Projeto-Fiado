<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
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
     * @param $idLoja
     * @param ?string $like
     * @param ?bool $active
     * @return mixed
     */
    public static function totalProduto($idLoja, ?string $like = null, ?bool $active = null)
    {
        $dao = new ProdutoDao();

        $data = new ParamData(new ParamItem('id_loja', $idLoja, \PDO::PARAM_INT));

        if ($active !== null) {
            $data->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        if ($like !== null) {
            $data->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        return $dao->countProduto("id_loja = :id_loja {$like} {$active}", $data);
    }

    /**
     * @param $idLoja
     * @param int $first
     * @param int $quantity
     * @param ?bool $active
     * @param ?string $like
     */
    public static function listProduto($idLoja, int $first, int $quantity, ?bool $active = null, ?string $like = null)
    {
        $dao = new ProdutoDao();

        $data = new ParamData(null);
        
        $data->addData('first', $first, \PDO::PARAM_INT);
        $data->addData('last', $quantity, \PDO::PARAM_INT);
        $data->addData('id_loja', $idLoja, \PDO::PARAM_INT);

        if ($active !== null) {
            $data->addData('active', $active, \PDO::PARAM_BOOL);
            $active = "AND active = :active";
        }

        if ($like !== null) {
            $data->addData('like', "%$like%", \PDO::PARAM_STR);
            $like = "AND name LIKE :like";
        }

        $arr = $dao->listProduto("id_loja = :id_loja $active $like", $data);

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
        $loja = LojaService::getLojaById($idLoja) ?: null;
        $date = date('Y-m-d H:i:s');

        $validation = new ProdutoValidate($id, $loja, $name, $price, $date, $description, $active);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

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