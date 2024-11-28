<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class FiadoItemDao extends Model
{
    /**
     * @param ParamData $data
     * @return mixed
     */
    public function listFiadoItem(ParamData $data)
    {
        $statement = $this->select('fiado_itens', 'id_fiado = :id_fiado', $data);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getFiadoItemById(ParamData $data)
    {
        $statement = $this->select('fiado_itens', 'id = :id', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addFiadoItem(array $data)
    {
        return $this->insert('fiado_itens', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editFiadoItem(array $data)
    {
        return $this->update('fiado_itens', $data, "id = {$data['id']}");
    }
}