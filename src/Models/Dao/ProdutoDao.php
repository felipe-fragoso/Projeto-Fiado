<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class ProdutoDao extends Model
{
    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getProduto(ParamData $data)
    {
        $statement = $this->select('produto', 'id = :id', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $condition
     * @param ParamData $data
     * @return mixed
     */
    public function listProduto(string $condition, ParamData $data)
    {
        $statement = $this->select('produto', $condition, $data);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addProduto(array $data)
    {
        return $this->insert('produto', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editProduto(array $data)
    {
        return $this->update('produto', $data, "id = {$data['id']}");
    }
}