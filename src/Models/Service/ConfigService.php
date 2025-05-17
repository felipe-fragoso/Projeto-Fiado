<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ConfigDao;
use Fiado\Models\Entity\Config;
use Fiado\Models\Validation\ConfigValidate;

class ConfigService
{
    /**
     * @var ConfigDao
     */
    private static $dao;

    public static function getDao()
    {
        if (!isset(self::$dao)) {
            self::$dao = new ConfigDao();
        }

        return self::$dao;
    }

    /**
     * @param array $arr
     */
    private static function getConfigObj(array $arr)
    {
        return new Config(
            $arr['id'],
            new LazyDataObj($arr['id_loja'], function ($id) {return LojaService::getLojaById($id);}),
            $arr['pay_limit'],
            $arr['max_credit'],
        );
    }

    /**
     * @param int $idLoja
     */
    public static function getConfigByLoja(int $idLoja)
    {
        $arr = self::getDao()->getConfigByLoja(new ParamData(new ParamItem('id_loja', $idLoja)));

        if ($arr) {
            return self::getConfigObj($arr);
        }

        return false;
    }

    /**
     * @param int $id
     */
    public static function getConfigById(int $id)
    {
        $arr = self::getDao()->getConfigById(new ParamData(new ParamItem('id', $id, \PDO::PARAM_INT)));

        if ($arr) {
            return self::getConfigObj($arr);
        }

        return false;
    }

    /**
     * @param $id
     * @param $idLoja
     * @param $payLimit
     * @param $maxCredit
     */
    public static function salvar($id, $idLoja, $payLimit, $maxCredit)
    {
        $loja = LojaService::getLojaById($idLoja) ?: null;

        $validation = new ConfigValidate($id, $loja, $payLimit, $maxCredit);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $config = new Config($id, $loja, $payLimit, $maxCredit);

        if ($config->getId()) {
            return self::getDao()->editConfig([
                'id' => $config->getId(),
                'pay_limit' => $config->getPayLimit(),
                'max_credit' => $config->getMaxCredit(),
            ]);
        }

        return self::getDao()->addConfig([
            'id_loja' => $config->getLoja()->getId(),
            'pay_limit' => $config->getPayLimit(),
            'max_credit' => $config->getMaxCredit(),
        ]);
    }
}