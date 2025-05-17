<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class StripeInvoiceDao extends Model
{
    /**
     * @param string $condition
     * @param ParamData $data
     * @return mixed
     */
    public function getStripeInvoice(string $condition, ParamData $data)
    {
        $statement = $this->select('stripe_invoice', $condition, $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addStripeInvoice(array $data)
    {
        return $this->insert('stripe_invoice', $data);
    }
}