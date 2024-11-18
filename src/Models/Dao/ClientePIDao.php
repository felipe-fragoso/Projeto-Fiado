<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class ClientePIDao extends Model
{
    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getClientePI(ParamData $data)
    {
        $statement = $this->select('cliente_personal_info', 'id_cliente = :id_cliente', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addCliente(array $data)
    {
        return $this->insert('cliente_personal_info', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editCliente(array $data)
    {
        return $this->update('cliente_personal_info', $data, "id = {$data['id']}");
    }
}