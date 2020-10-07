<?php

namespace App\Database\Repositories;


use App\Contracts\Database\Repositories\Repository as RepositoryContract;
use App\Database\Models\Model;


class Repository implements RepositoryContract {
    private $app;
    private $conn;
    private $filters;

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * this method should be overrided in
     * repositories, those extend this repository
     * class
     */

    public function model() {
        return "class";
    }

    /**
     * this method should be overrided in
     * repositories, those extend this repository
     * class
     */

    public function table() {
        return "table";
    }

    public function conn() {
        if($this->conn === null) {
            $this->conn = $this->app->db()->connection();
        }
        return $this->conn;
    }

    private function prepareAndExecute($sql, $data) {
        if(!($stmt = $this->conn()->prepare($sql))) {
            throw new \Exception(
                "Couldn't prepare statement for table \"" . $this->table() . "\"",
                1
            );
        }
        if(!$stmt->execute($data)) {
            throw new \Exception(
                "Couldn't execute statement for table \"" . $this->table() . "\"",
                1
            );
        }
        return $stmt;
    }

    public function add($modelData) {
        $prefix = "INSERT INTO " . $this->table() . " (";
        $suffix = " VALUES (";

        $class = $this->model();
        $model = new $class();
        $model->assign($modelData);
        $all = $model->getAll();

        $data = [];
        $i = 0;
        foreach($all as $fieldName => $value) {
            if($fieldName === "id") {
                continue;
            }
            $data[":" . $fieldName] = $value["value"];
            if($i !== 0) {
                $prefix .= ", ";
                $suffix .= ", ";
            }
            $prefix .= $fieldName;
            $suffix .= ":" . $fieldName;
            $i++;
        }
        $prefix .= ")";
        $suffix .= ")";
        $sql = $prefix . $suffix;
        $this->prepareAndExecute($sql, $data);
    }

    private function &filters() {
        if($this->filters === null) {
            $this->filters = [];
        }
        return $this->filters;
    }

    private function addRawToFilters($filterString) {
        $this->filters()[] = [
            "type" => "raw",
            "value" => $filterString
        ];
    }

    private function addToFilters($fieldName, $relation, $value) {
        $this->filters()[] = [
            "type" => "checked",
            "fieldName" => $fieldName,
            "relation" => $relation,
            "value" => $value
        ];
    }

    private function flushFilters() {
        $this->filters = null;
    }

    public function whereRaw($filterString) {
        $this->addRawToFilters($filterString);
        return $this;
    }

    public function where($fieldName, $value) {
        $this->addToFilters($fieldName, "=", $value);
        return $this;
    }

    private function prepareSqlForFilters(&$data) {
        $sql = "";
        $filtersAll = $this->filters();
        $i = 0;
        foreach($filtersAll as $filter) {
            if($i === 0) {
                $sql .= " WHERE ";
            } else {
                $sql .= " AND ";
            }
            if($filter["type"] === "raw") {
                $sql .= $filter["value"];
            } else {
                $data[":" . $filter["fieldName"]] = $filter["value"];
                $sql .= $filter["fieldName"] . " " . $filter["relation"] . " :" . $filter["fieldName"];
            }
            $i++;
        }
        return $sql;
    }

    public function get() {
        $data = [];
        $sql = "SELECT * FROM " . $this->table()
            . " "
            . $this->prepareSqlForFilters($data);
        $stmt = $this->prepareAndExecute($sql, $data);
        // this is very very important
        // you must flush filters
        $this->flushFilters(); // okay, filters are flushed
        return $stmt->fetchAll();
    }

    private function prepareSqlForUpdates($updates, &$data) {
        $sql = "";
        $i = 0;
        foreach($updates as $fieldName => $value) {
            if($i === 0) {
                $sql .= " SET ";
            } else {
                $sql .= ", ";
            }
            $sql .= $fieldName . " = :__updated__" . $fieldName;
            $data[":__updated__" . $fieldName] = $value;
        }
        return $sql;
    }

    public function update($updates) {
        $data = [];
        $sql = "UPDATE " . $this->table()
            . " "
            . $this->prepareSqlForUpdates($updates, $data)
            . " "
            . $this->prepareSqlForFilters($data);
        $this->prepareAndExecute($sql, $data);
        // this is very very important
        // you must flush filters
        $this->flushFilters(); // okay, filters are flushed
    }

    public function delete() {
        $data = [];
        $sql = "DELETE FROM " . $this->table()
            . " "
            . $this->prepareSqlForFilters($data);
        $this->prepareAndExecute($sql, $data);
        // this is very very important
        // you must flush filters
        $this->flushFilters(); // okay, filters are flushed
    }

    public function find($id) {
        $sql = "SELECT * FROM " . $this->table()
            . " "
            . "WHERE id = :id";
        $stmt = $this->prepareAndExecute($sql, [
            ":id" => $id
        ]);
        return $stmt->fetch();
    }
}