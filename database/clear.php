<?php

require_once __DIR__ . "/../vendor/autoload.php";


/**
 * list table names those you want to
 * drop when this script runs
 */

$tableNames = [
    "users"
];


/**
 * creating tables using the sql declared above
 */
$dbconfig = require __DIR__ . "/config.php";
$class = $dbconfig["class"];
$db = new $class($dbconfig["config"]);

try {
    $conn = $db->connection();
    $prefix = "DROP TABLE IF EXISTS ";
    foreach($tableNames as $tableName) {
        $sql = $prefix . " " . $tableName;
        $conn->exec($sql);
        echo "dropped \"$tableName\" successfully\n";
    }
} catch(\PDOException $e) {
    echo "error:\n";
    echo $e->getMessage();
    echo "\n";
}