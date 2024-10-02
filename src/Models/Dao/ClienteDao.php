<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;

class ClienteDao extends Model
{
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