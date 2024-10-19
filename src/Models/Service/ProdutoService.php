<?php

namespace Fiado\Models\Service;

use Fiado\Core\Auth;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ProdutoDao;
use Fiado\Models\Entity\Produto;
use Fiado\Models\Validation\ProdutoValidate;

class ProdutoService
{
    /**
     * @param int $id
     * @return mixed
     */
    public static function getProduto(int $id)
    {
        $dao = new ProdutoDao();

        return $dao->getProduto(new ParamData(new ParamItem('id', $id, \PDO::PARAM_INT)));
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

        return $dao->listProduto('1=1 LIMIT :first, :last', $data);
    }

    /**
     * @param $id
     * @param $name
     * @param $price
     * @param $active
     * @param $description
     * @return mixed
     */
    public static function salvar($id, $name, $price, $active, $description)
    {
        $validation = new ProdutoValidate($name, $price, $active, $description);

        if ($validation->getNumErrors()) {
            return false;
        }

        $loja = LojaService::getLojaByEmail(Auth::getEmail());
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