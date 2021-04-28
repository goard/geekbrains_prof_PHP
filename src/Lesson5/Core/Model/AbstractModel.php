<?php

namespace Lesson5\Core\Model;

use DB;

abstract class AbstractModel
{
    protected $db;
    protected $tableName;
    protected $params;

    public function __construct()
    {
        $this->db = DB::getDbConnection();
    }

    public function getById(int $id) : self
    {
        $stm = $this->db->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $stm->bindValue(1, $id);
        $stm->execute();
        $this->params = $stm->fetch();
        return $this;
    }

    public function getByAttribute(array $columnToValue) : self
    {
        if (count($columnToValue) < 1) {
            return $this;
        }
        $preparedQueryList = [];
        foreach (array_keys($columnToValue) as $column) {
            $preparedQueryList[] = "`{$column}` = :{$column}";
        }
        $preparedQuery = "SELECT * FROM {$this->tableName} WHERE " . implode(" AND ", $preparedQueryList) . " LIMIT 1";
        $stm = $this->db->prepare($preparedQuery);
        foreach ($columnToValue as $column => $value) {
            $stm->bindValue($column, $value);
        }
        $stm->execute();
        $this->params = $stm->fetch();
        return $this;
    }

    public function getData($key = null)
    {
        if ($key === null) {
            return $this->params;
        }
        return $this->params[$key] ?? null;
    }

    public function setData($key, $value) : self
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function save() : self
    {
        if (empty($this->params)) {
            return $this;
        }
        if (empty($this->params['id'])) {
            $this->create();
        } else {
            $this->update();
        }
        return $this;
    }

    protected function create() : self
    {
        $preparedQuery = "INSERT INTO {$this->tableName} (`"
            . implode("`, `", array_keys($this->params))
            . "`) VALUES (:"
            . implode(", :", array_keys($this->params))
            . ")";

        // (name, surname, email) values (:name, :surname...)
        $stm = $this->db->prepare($preparedQuery);
        foreach ($this->params as $column => $value) {
            $stm->bindValue($column, $value);
        }
        $stm->execute();
        return $this;
    }

    protected function update() : self
    {
        $preparedQueryList = [];
        foreach (array_keys($this->params) as $column) {
            $preparedQueryList[] = "`{$column}` = :{$column}";
        }
        // set name = :name, surname = :surname, ...
        $preparedQuery = "UPDATE {$this->tableName} SET " . implode(", ", $preparedQueryList) . " WHERE id = :id";
        $stm = $this->db->prepare($preparedQuery);
        foreach ($this->params as $column => $value) {
            $stm->bindValue($column, $value);
        }
        $stm->execute();
        return $this;
    }

    public function getId() : ?int
    {
        return $this->params['id'] ?? null;
    }
}
