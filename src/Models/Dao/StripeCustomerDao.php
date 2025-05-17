<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class StripeCustomerDao extends Model
{
    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getStripeCustomer(ParamData $data)
    {
        $statement = $this->select('stripe_customer', 'email = :email', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addStripeCustomer(array $data)
    {
        return $this->insert('stripe_customer', $data);
    }
}