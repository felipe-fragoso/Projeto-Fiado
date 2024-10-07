<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class LojaDao extends Model
{
    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getLojaByEmail(ParamData $data)
    {
        $statement = $this->select('loja', 'email = :email', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addLoja(array $data)
    {
        return $this->insert('loja', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editLoja(array $data)
    {
        return $this->update('loja', $data, "id = {$data['id']}");
    }
}