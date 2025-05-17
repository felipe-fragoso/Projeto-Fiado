<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\LazyDataObj;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\StripeInvoiceDao;
use Fiado\Models\Entity\StripeInvoice;
use Fiado\Models\Validation\StripeInvoiceValidate;

class StripeInvoiceService
{
    /**
     * @var StripeInvoiceDao
     */
    private static $dao;

    public static function getDao()
    {
        if (!isset(self::$dao)) {
            self::$dao = new StripeInvoiceDao();
        }

        return self::$dao;
    }

    /**
     * @param $idFiado
     */
    public static function getInvoice($idFiado)
    {
        $paramData = new ParamData(new ParamItem('id_fiado', $idFiado, \PDO::PARAM_INT));
        $arr = self::getDao()->getStripeInvoice('id_fiado = :id_fiado', $paramData);

        if ($arr) {
            return new StripeInvoice(
                $arr['id'],
                new LazyDataObj($arr['id_fiado'], function ($id) {return CompraService::getCompra($id);}),
                $arr['id_invoice'],
            );
        }

        return false;
    }

    /**
     * @param $idInvoice
     */
    public static function getInvoiceById($idInvoice)
    {
        $paramData = new ParamData(new ParamItem('id_invoice', $idInvoice, \PDO::PARAM_STR));
        $arr = self::getDao()->getStripeInvoice('id_invoice = :id_invoice', $paramData);

        if ($arr) {
            return new StripeInvoice(
                $arr['id'],
                new LazyDataObj($arr['id_fiado'], function ($id) {return CompraService::getCompra($id);}),
                $arr['id_invoice'],
            );
        }

        return false;
    }

    /**
     * @param $id
     * @param $idFiado
     * @param $idInvoice
     */
    public static function salvar($id, $idFiado, $idInvoice)
    {
        $fiado = CompraService::getCompra($idFiado) ?: null;

        $validation = new StripeInvoiceValidate($id, $fiado, $idInvoice);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $stripeInvoice = new StripeInvoice($id, $fiado, $idInvoice);

        return self::getDao()->addStripeInvoice([
            'id_fiado' => $stripeInvoice->getFiado()->getId(),
            'id_invoice' => $stripeInvoice->getIdInvoice(),
        ]);
    }
}