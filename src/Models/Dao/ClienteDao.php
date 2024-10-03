<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class ClienteDao extends Model
{
    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getClienteByEmail(ParamData $data)
    {
        $statement = $this->select('cliente', 'email = :email', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addCliente(array $data)
    {
        return $this->insert('cliente', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editCliente(array $data)
    {
        return $this->update('cliente', $data, "id = {$data['id']}");
    }
}