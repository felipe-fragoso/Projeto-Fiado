<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ClienteCompletionLinkDao;
use Fiado\Models\Entity\ClienteCompletionLink;
use Fiado\Models\Validation\ClienteCompletionLinkValidate;

class ClienteCompletionLinkService
{
    /**
     * @var ClienteCompletionLinkDao
     */
    private static $dao;

    public static function getDao()
    {
        if (!isset(self::$dao)) {
            self::$dao = new ClienteCompletionLinkDao();
        }

        return self::$dao;
    }

    /**
     * @param array $arr
     */
    private static function getClienteCompletionLinkObj(array $arr)
    {
        return new ClienteCompletionLink(
            $arr['id'],
            $arr['hash'],
            new LazyDataObj($arr['id_cliente'], function ($id) {return ClienteService::getClienteById($id);}),
            new LazyDataObj($arr['id_loja'], function ($id) {return LojaService::getLojaById($id);}),
            $arr['used'],
            $arr['valid_until']
        );
    }

    /**
     * @param string $hash
     */
    public static function getClienteCompletionLink(string $hash)
    {
        $params = new ParamData(new ParamItem('hash', $hash));
        $arr = self::getDao()->getClienteCompletionLink('hash = :hash', $params);

        if ($arr) {
            return self::getClienteCompletionLinkObj($arr);
        }

        return false;
    }

    /**
     * @param int $id
     */
    public static function getClienteCompletionLinkById(int $id)
    {
        $params = new ParamData(new ParamItem('id', $id));
        $arr = self::getDao()->getClienteCompletionLink('id = :id', $params);

        if ($arr) {
            return self::getClienteCompletionLinkObj($arr);
        }

        return false;
    }

    /**
     * @param $id
     * @param $hash
     * @param $idCliente
     * @param $idLoja
     * @param $used
     * @param $validUntil
     * @return mixed
     */
    public static function salvar($id, $hash, $idCliente, $idLoja, $used, $validUntil)
    {
        $cliente = ClienteService::getClienteById($idCliente) ?: null;
        $loja = LojaService::getLojaById($idLoja) ?: null;

        $validation = new ClienteCompletionLinkValidate($id, $hash, $cliente, $loja, $used, $validUntil);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $clienteCompletionLink = new ClienteCompletionLink($id, $hash, $cliente, $loja, $used, $validUntil);

        if ($clienteCompletionLink->getId()) {
            return self::getDao()->editCliente([
                'id' => $clienteCompletionLink->getId(),
                'hash' => $clienteCompletionLink->getHash(),
                'id_cliente' => $clienteCompletionLink->getCliente()->getId(),
                'id_loja' => $clienteCompletionLink->getLoja()->getId(),
                'used' => $clienteCompletionLink->getUsed(),
                'valid_until' => $clienteCompletionLink->getValidUntil(),
            ]);
        }

        return self::getDao()->addCliente([
            'hash' => $clienteCompletionLink->getHash(),
            'id_cliente' => $clienteCompletionLink->getCliente()->getId(),
            'id_loja' => $clienteCompletionLink->getLoja()->getId(),
            'used' => $clienteCompletionLink->getUsed(),
            'valid_until' => $clienteCompletionLink->getValidUntil(),
        ]);
    }
}