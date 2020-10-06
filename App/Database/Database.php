<?php

namespace App\Database;


use App\Contracts\Database\Database as DatabaseContract;


class Database implements DatabaseContract {
    private $config;
    private $conn;

    public function __construct($config) {
        $this->config = $config;
    }

    public function connection() {
        if($this->conn === null) {
            $dsn = "pgsql:";
            $dsn .= "host=" . $this->config["host"] . ";";
            $dsn .= "port=" . $this->config["port"] . ";";
            $dsn .= "dbname=" . $this->config["dbname"];
            $this->conn = new \PDO(
                $dsn,
                $this->config["user"],
                $this->config["password"]
            );
        }
        return $this->conn;
    }
}