<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class LojaPIDao extends Model
{
    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getLojaPIByLoja(ParamData $data)
    {
        $statement = $this->select('loja_personal_info', 'id_loja = :id_loja', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getLojaPIById(ParamData $data)
    {
        $statement = $this->select('loja_personal_info', 'id = :id', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addLojaPI(array $data)
    {
        return $this->insert('loja_personal_info', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editLojaPI(array $data)
    {
        return $this->update('loja_personal_info', $data, "id = {$data['id']}");
    }
}