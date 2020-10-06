<?php

namespace Tests\App\Database;


use PHPUnit\Framework\TestCase;
use App\Contracts\Database\Database as DatabaseContract;
use App\Database\Database;


class DatabaseTest extends TestCase {
    public function testContract() {
        $db = new Database(null);
        $this->assertTrue($db instanceof DatabaseContract);
    }

    public function testConnection() {
        $config = (require __DIR__ . "/../../../database/config.php")["config"];

        $db = new Database($config);

        $conn = $db->connection();
        $this->assertTrue($conn instanceof \PDO);

        try {
            // drop table if exists any table by name 'test_table'
            $dropTestTableIfExists = "drop table if exists test_table";
            $conn->exec($dropTestTableIfExists);

            // create table 'test_table'
            $createTestTable = "create table if not exists test_table (
                id serial,
                msg varchar(255)
            )";
            $conn->exec($createTestTable);

            // insert data into 'test_table'
            $originalMsg = 'some-message';
            $insertdata = "insert into test_table(msg) values(:msg)";
            $stmt = $conn->prepare($insertdata);
            $stmt->execute([
                ":msg" => $originalMsg
            ]);

            // query data from 'test_table'
            $queryData = "select id, msg from test_table where msg = :msg";
            $stmt = $conn->prepare($queryData);
            $stmt->execute([
                ":msg" => 'some-message'
            ]);
            while($row = $stmt->fetch()) {
                $id = $row["id"];
                $msg = $row["msg"];
                $this->assertEquals($msg, $originalMsg);
            }
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }
}