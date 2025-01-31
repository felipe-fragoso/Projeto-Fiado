<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\LojaPiDao;
use Fiado\Models\Entity\LojaPi;
use Fiado\Models\Validation\LojaPiValidate;

class LojaPiService
{
    /**
     * @param array $arr
     */
    private static function getLojaPiObj(array $arr)
    {
        return new LojaPi(
            $arr['id'],
            new LazyDataObj($arr['id_loja'], function ($id) {return LojaService::getLojaById($id);}),
            $arr['address'],
            $arr['telephone'],
            $arr['description'],
            $arr['established'],
            $arr['open_hour'],
            $arr['close_hour'],
        );
    }

    /**
     * @param int $idLoja
     */
    public static function getLojaPiByLoja(int $idLoja)
    {
        $dao = new LojaPiDao();

        $arr = $dao->getLojaPiByLoja(new ParamData(new ParamItem('id_loja', $idLoja)));

        if ($arr) {
            return self::getLojaPiObj($arr);
        }

        return false;
    }

    /**
     * @param int $id
     */
    public static function getLojaPiById(int $id)
    {
        $dao = new LojaPiDao();

        $arr = $dao->getLojaPiById(new ParamData(new ParamItem('id', $id)));

        if ($arr) {
            return self::getLojaPiObj($arr);
        }

        return false;
    }

    /**
     * @param $id
     * @param $idLoja
     * @param $address
     * @param $telephone
     * @param $description
     * @param $established
     * @param $openHour
     * @param $closeHour
     * @return mixed
     */
    public static function salvar($id, $idLoja, $address, $telephone, $description, $established, $openHour, $closeHour)
    {
        $loja = LojaService::getLojaById($idLoja) ?: null;

        $validation = new LojaPiValidate($id, $loja, $address, $telephone, $description, $established, $openHour, $closeHour);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $lojaPI = new LojaPi($id, $loja, $address, $telephone, $description, $established, $openHour, $closeHour);
        $dao = new LojaPiDao();

        if ($lojaPI->getId()) {
            return $dao->editLojaPi([
                'id' => $lojaPI->getId(),
                'address' => $lojaPI->getAddress(),
                'telephone' => $lojaPI->getTelephone(),
                'description' => $lojaPI->getDescription(),
                'established' => $lojaPI->getEstablished(),
                'open_hour' => $lojaPI->getOpenHour(),
                'close_hour' => $lojaPI->getCloseHour(),
            ]);
        }

        return $dao->addLojaPi([
            'id_loja' => $lojaPI->getLoja()->getId(),
            'address' => $lojaPI->getAddress(),
            'telephone' => $lojaPI->getTelephone(),
            'description' => $lojaPI->getDescription(),
            'established' => $lojaPI->getEstablished(),
            'open_hour' => $lojaPI->getOpenHour(),
            'close_hour' => $lojaPI->getCloseHour(),
        ]);
    }
}