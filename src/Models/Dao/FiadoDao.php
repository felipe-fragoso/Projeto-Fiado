<?php

namespace Fiado\Models\Dao;

use Fiado\Core\Model;
use Fiado\Helpers\ParamData;

class FiadoDao extends Model
{
    /**
     * @param string $condition
     * @param ParamData $data
     * @return mixed
     */
    public function listFiado(string $condition, ParamData $data)
    {
        $statement = $this->select('fiado', $condition, $data);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function countFiado(ParamData $data)
    {
        $statement = $this->select('fiado', 'id_loja = :id_loja', $data, 'COUNT(*)');

        return $statement->fetch(\PDO::FETCH_COLUMN);
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function listFiadoCliente(ParamData $data)
    {
        $statement = $this->select('fiado', 'id_loja = :id_loja AND id_cliente = :id_cliente', $data);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $condition
     * @param ParamData $data
     * @return mixed
     */
    public function listFiadoPendente($condition, ParamData $data)
    {
        $statement = $this->select('fiado', $condition, $data);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function countFiadoPendente(ParamData $data)
    {
        $statement = $this->select('fiado', 'id_loja = :id_loja AND paid = :paid', $data, 'COUNT(*)');

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
     * @param ParamData $data
     * @return mixed
     */
    public function total(ParamData $data)
    {
        $setPaid = array_filter($data->getData(), function ($paramItem) {
            return $paramItem->getValue() === null;
        });

        $paid = '= :paid';
        if ($setPaid) {
            $paid = 'IN(:paid, 0, 1)';
        }

        $statement = $this->select('fiado', "paid $paid AND id_loja = :id_loja AND date BETWEEN :start AND :end", $data, "SUM(`total`)");

        return $statement->fetchColumn();
    }

    /**
     * @param ParamData $data
     * @return mixed
     */
    public function totalCliente(ParamData $data)
    {
        $setPaid = array_filter($data->getData(), function ($paramItem) {
            return $paramItem->getValue() === null;
        });

        $paid = '= :paid';
        if ($setPaid) {
            $paid = 'IN(:paid, 0, 1)';
        }

        $statement = $this->select(
            'fiado',
            "paid $paid AND id_loja = :id_loja AND id_cliente = :id_cliente AND date BETWEEN :start AND :end",
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