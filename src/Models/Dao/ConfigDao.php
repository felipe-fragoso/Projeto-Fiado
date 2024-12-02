<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class ConfigDao extends Model
{
    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getConfigByLoja(ParamData $data)
    {
        $statement = $this->select('loja_config', 'id_loja = :id_loja', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getConfigById(ParamData $data)
    {
        $statement = $this->select('loja_config', 'id = :id', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addConfig(array $data)
    {
        return $this->insert('loja_config', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editConfig(array $data)
    {
        return $this->update('loja_config', $data, "id = {$data['id']}");
    }
}