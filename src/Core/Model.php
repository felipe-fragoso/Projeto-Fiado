<?php

namespace Fiado\Core;

use Fiado\Helpers\ParamData;

class Model
{
    /**
     * @var \PDO
     */
    private $db;

    public function __construct()
    {
        if (!$this->db) {
            try {
                $this->db = new \PDO(
                    "mysql:host={$_SERVER['DB_HOST']};dbname={$_SERVER['DB_NAME']};charset={$_SERVER['DB_CHARSET']}",
                    $_SERVER["DB_USER"],
                    $_SERVER["DB_PASS"]
                );
            } catch (\PDOException $e) {
                throw new \Exception("Couldn't connect with database" . $e->getMessage());
            }
        }
    }

    public function beginTransation()
    {
        try {
            $this->db->beginTransaction();
        } catch (\PDOException $e) {
            throw new \Exception("Couldn't begin transaction" . $e->getMessage());
        }
    }

    public function commit()
    {
        try {
            $this->db->commit();
        } catch (\PDOException $e) {
            throw new \Exception("There is no transaction active" . $e->getMessage());
        }
    }

    public function rollback()
    {
        try {
            $this->db->rollBack();
        } catch (\PDOException $e) {
            throw new \Exception("There is no transaction active" . $e->getMessage());
        }
    }

    /**
     * @param $table
     * @param $condition
     * @param array $values
     * @param $cols
     */
    public function select($table, $condition, ParamData $data, $cols = "*"): \PDOStatement
    {
        $sql = "SELECT {$cols} FROM {$table} WHERE {$condition}";

        try {
            $statement = $this->db->prepare($sql);

            if ($data) {
                $data = $data->getData();
                foreach ($data as $param) {
                    $statement->bindValue(":{$param->getLabel()}", $param->getValue(), $param->getType());
                }
            }

            $statement->execute();

            return $statement;
        } catch (\PDOException $e) {
            throw new \Exception("Couldn't query database: " . $e->getMessage());
        }
    }

    /**
     * @param $table
     * @param array $data
     */
    public function insert($table, array $data): string | false
    {
        $fields = implode(', ', array_keys($data));
        $bindValues = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$bindValues})";

        try {
            $statement = $this->db->prepare($sql);

            if ($data) {
                foreach ($data as $key => $value) {
                    $statement->bindValue(":{$key}", $value);
                }
            }

            $statement->execute();

            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Couldn't insert register" . $e->getMessage());
        }
    }

    /**
     * @param $table
     * @param array $data
     * @param $condition
     */
    public function update($table, array $data, $condition): int
    {
        $bindData = "";

        foreach ($data as $key => $value) {
            $bindData .= "{$key}=:{$key}, ";
        }

        $bindData = rtrim($bindData, ', ');

        $sql = "UPDATE {$table} SET {$bindData} WHERE {$condition}";

        try {
            $statement = $this->db->prepare($sql);

            if ($data) {
                foreach ($data as $key => $value) {
                    $statement->bindValue(":{$key}", $value);
                }
            }

            $statement->execute();

            return $statement->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception("Couldn't update register" . $e->getMessage());
        }
    }

    /**
     * @param $table
     * @param $condition
     * @param array $data
     */
    public function delete($table, $condition, $data = []): int
    {
        $sql = "DELETE FROM {$table} WHERE $condition";

        try {
            $statement = $this->db->prepare($sql);

            if ($data) {
                foreach ($data as $key => $value) {
                    $statement->bindValue(":$key", $value);
                }
            }

            $statement->execute();

            return $statement->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception("Couldn't delete register" . $e->getMessage());
        }
    }
}