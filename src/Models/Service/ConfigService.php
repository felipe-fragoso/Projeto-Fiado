<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ConfigDao;
use Fiado\Models\Entity\Config;
use Fiado\Models\Validation\ConfigValidate;

class ConfigService
{
    /**
     * @param array $arr
     */
    private static function getConfigObj(array $arr)
    {
        return new Config(
            $arr['id'],
            new LazyDataObj($arr['id_loja'], function ($id) {return ConfigService::getConfigById($id);}),
            $arr['pay_limit'],
            $arr['max_credit'],
        );
    }

    /**
     * @param int $idLoja
     */
    public static function getConfigByLoja(int $idLoja)
    {
        $dao = new ConfigDao();

        $arr = $dao->getConfigByLoja(new ParamData(new ParamItem('id_loja', $idLoja)));

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
        $dao = new ConfigDao();

        $arr = $dao->getConfigById(new ParamData(new ParamItem('id', $id, \PDO::PARAM_INT)));

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
        $loja = LojaService::getLojaById($idLoja);

        $validation = new ConfigValidate($id, $loja, $payLimit, $maxCredit);

        if ($validation->getQtyErrors()) {
            return false;
        }

        $config = new Config($id, $loja, $payLimit, $maxCredit);
        $dao = new ConfigDao();

        if ($config->getId()) {
            return $dao->editConfig([
                'id' => $config->getId(),
                'pay_limit' => $config->getPayLimit(),
                'max_credit' => $config->getMaxCredit(),
            ]);
        }

        return $dao->addConfig([
            'id_loja' => $config->getLoja()->getId(),
            'pay_limit' => $config->getPayLimit(),
            'max_credit' => $config->getMaxCredit(),
        ]);
    }
}