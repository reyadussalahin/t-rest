<?php

use App\Database\Database;


return [
    "class" => Database::class,
    "config" => [
        "host" => "localhost",
        "port" => "5432",
        "dbname" => "test",
        "user" => "root",
        "password" => "********"
    ]
];