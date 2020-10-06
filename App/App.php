<?php

namespace App;


use HelloWorld\App\App as HelloWorldApp;


class App extends HelloWorldApp {
    private $dbconfig;
    private $db;

    public function __construct($base, $globals) {
        parent::__construct($base, $globals);
    }

    private function dbconfig() {
        if($this->dbconfig === null) {
            $this->dbconfig = require $this->base() . "/database/config.php";
        }
        return $this->dbconfig;
    }

    public function db() {
        if($this->db === null) {
            $dbc = $this->dbconfig();
            $this->db = new $dbc["class"]($dbc["config"]);
        }
        return $this->db;
    }
}