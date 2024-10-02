<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;

class LojaDao extends Model
{
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