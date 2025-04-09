<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\LojaDao;
use Fiado\Models\Entity\Loja;
use Fiado\Models\Validation\LojaValidate;

class LojaService
{
    /**
     * @var LojaDao
     */
    private static $dao;

    public static function getDao()
    {
        if (!isset(self::$dao)) {
            self::$dao = new LojaDao();
        }

        return self::$dao;
    }

    /**
     * @param array $arr
     */
    private static function getLojaObj(array $arr)
    {
        return new Loja($arr['id'], $arr['cnpj'], $arr['name'], $arr['email'], $arr['senha'], $arr['date']);
    }

    /**
     * @param string $email
     */
    public static function getLojaByEmail(string $email)
    {
        $arr = self::getDao()->getLojaByEmail(new ParamData(new ParamItem('email', $email)));

        if ($arr) {
            return self::getLojaObj($arr);
        }

        return false;
    }

    /**
     * @param int $id
     */
    public static function getLojaById(int $id)
    {
        $arr = self::getDao()->getLojaById(new ParamData(new ParamItem('id', $id)));

        if ($arr) {
            return self::getLojaObj($arr);
        }

        return false;
    }

    /**
     * @param Loja $store
     * @return mixed
     */
    public static function salvar($id, $cnpj, $name, $email, $password, $conPassword, $date = null)
    {
        $date = $date ?? date('Y-m-d H:i:s');

        $validation = new LojaValidate($id, $cnpj, $name, $email, $password, $conPassword, $date);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $store = new Loja($id, $cnpj, $name, $email, $password, $date);

        if ($store->getId()) {
            return self::getDao()->editLoja([
                'id' => $store->getId(),
                'name' => $store->getName(),
                'cnpj' => $store->getCnpj(),
                'email' => $store->getEmail(),
                'senha' => $store->getSenha(),
                'date' => $store->getDate(),
            ]);
        }

        return self::getDao()->addLoja([
            'name' => $store->getName(),
            'cnpj' => $store->getCnpj(),
            'email' => $store->getEmail(),
            'senha' => $store->getSenha(),
            'date' => $store->getDate(),
        ]);
    }
}