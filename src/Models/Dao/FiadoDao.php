<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class FiadoDao extends Model
{
    /**
     * @param string $condition
     * @param ParamData $data
     * @param ?string $limit
     * @param ?string $orderBy
     */
    public function listFiado(string $condition, ParamData $data, ?string $limit = null, ?string $orderBy = null)
    {
        $condition = $condition . ($orderBy ? " ORDER BY {$orderBy}" : '');
        $condition = $condition . ($limit ? " LIMIT {$limit}" : '');

        $statement = $this->select('fiado, cliente', $condition, $data, 'fiado.*, cliente.name');

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $condition
     * @param ParamData $data
     * @return mixed
     */
    public function countFiado(string $condition, ParamData $data)
    {
        $statement = $this->select('fiado, cliente', $condition, $data, 'COUNT(*)');

        return $statement->fetch(\PDO::FETCH_COLUMN);
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function getFiadoById(ParamData $data)
    {
        $statement = $this->select('fiado', 'id = :id', $data);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $condition
     * @param ParamData $data
     * @return mixed
     */
    public function total(string $condition, ParamData $data)
    {
        $statement = $this->select(
            'fiado',
            $condition,
            $data,
            "SUM(`total`)"
        );

        return $statement->fetchColumn();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addFiado(array $data)
    {
        return $this->insert('fiado', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function editFiado(array $data)
    {
        return $this->update('fiado', $data, "id = {$data['id']}");
    }
}