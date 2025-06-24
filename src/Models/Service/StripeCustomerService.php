<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\StripeCustomerDao;
use Fiado\Models\Entity\StripeCustomer;
use Fiado\Models\Validation\StripeCustomerValidate;

class StripeCustomerService
{
    /**
     * @var StripeCustomerDao
     */
    private static $dao;

    public static function getDao()
    {
        if (!isset(self::$dao)) {
            self::$dao = new StripeCustomerDao();
        }

        return self::$dao;
    }

    /**
     * @param $email
     */
    public static function getCustomer($email)
    {
        $arr = self::getDao()->getStripeCustomer(new ParamData(new ParamItem('email', $email, \PDO::PARAM_STR)));

        if ($arr) {
            return new StripeCustomer(
                $arr['id'],
                $arr['id_customer'],
                $arr['email'],
            );
        }

        return false;
    }

    /**
     * @param $id
     * @param $idCustomer
     * @param $email
     */
    public static function salvar($id, $idCustomer, $email)
    {
        $validation = new StripeCustomerValidate($id, $idCustomer, $email);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $stripeCustomer = new StripeCustomer($id, $idCustomer, $email);

        return self::getDao()->addStripeCustomer([
            'id_customer' => $stripeCustomer->getIdCustomer(),
            'email' => $stripeCustomer->getEmail(),
        ]);
    }

    /**
     * @param int $id
     */
    public static function delete(int $id)
    {
        return self::getDao()->deleteStripeCustomer($id);
    }
}