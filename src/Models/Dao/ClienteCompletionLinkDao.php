<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class ClienteCompletionLinkDao extends Model
{
    /**
     * @param string $condition
     * @param ParamData $data
     * @return mixed
     */
    public function getClienteCompletionLink(string $condition, ParamData $data)
    {
        $statement = $this->select('cliente_completion_link', $condition, $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addCliente(array $data)
    {
        return $this->insert('cliente_completion_link', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editCliente(array $data)
    {
        return $this->update('cliente_completion_link', $data, "id = {$data['id']}");
    }
}