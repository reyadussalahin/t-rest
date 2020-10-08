<?php

require_once __DIR__ . "/../vendor/autoload.php";

/**
 * we're going to create each database manually
 * so, that we may write each of the constraint for each
 * column accurately
 */

$tableSqlArray["users"] = "CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username TEXT UNIQUE,
    email TEXT UNIQUE,
    password TEXT
)";

/**
 * add new tables here
 */



/**
 * creating tables using the sql declared above
 */
$dbconfig = require __DIR__ . "/config.php";
$class = $dbconfig["class"];
$db = new $class($dbconfig["config"]);

try {
    $conn = $db->connection();
    foreach($tableSqlArray as $tableName => $sql) {
        $conn->exec($sql);
        echo "created \"$tableName\" successfully\n";
    }
} catch(\PDOExcepton $e) {
    echo "error:\n";
    echo $e->getMessage();
    echo "\n";
}