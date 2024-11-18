<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class ClienteLojaDao extends Model
{
    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getClienteById(ParamData $data)
    {
        $statement = $this->select('cliente_loja', 'id = :id', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getClienteByLoja(ParamData $data)
    {
        $statement = $this->select('cliente_loja', 'id_cliente = :id_cliente AND id_loja = :id_loja', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addCliente(array $data)
    {
        return $this->insert('cliente_loja', $data);
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function listCliente(ParamData $data)
    {
        $statement = $this->select('cliente_loja', 'id_loja = :id_loja', $data);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editCliente(array $data)
    {
        return $this->update('cliente_loja', $data, "id = {$data['id']}");
    }
}