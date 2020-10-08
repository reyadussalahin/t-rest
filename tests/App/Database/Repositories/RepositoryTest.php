<?php

namespace Tests\App\Database\Repositories;


use PHPUnit\Framework\TestCase;
use App\Database\Models\Model;
use App\Contracts\Database\Repositories\Repository as RepositoryContract;
use App\Database\Repositories\Repository;


class SomeModel extends Model {
    public function __construct() {
        $this->id()
            ->string("name")
            ->int("age");
    }
}

class SomeRepo extends Repository {
    public function __construct($app) {
        parent::__construct($app);
    }

    public function createTable() {
        // drop table if exists any table by name 'test_table'
        $dropTestRepoIfExists = "DROP TABLE IF EXISTS test_repo";
        $this->conn()->exec($dropTestRepoIfExists);

        // create table 'test_table'
        $createTestRepo = "CREATE TABLE IF NOT EXISTS test_repo (
            id serial,
            name text,
            age int
        )";
        $this->conn()->exec($createTestRepo);
    }

    public function model() {
        return SomeModel::class;
    }

    public function table() {
        return "test_repo";
    }
}


class RespositoryTest extends TestCase {
    private function getRepo() {
        $base = __DIR__ . "/../../../..";
        $repo = new SomeRepo(
            new \App\App($base, null)
        );
        $repo->createTable();
        return $repo;
    }

    public function testContract() {
        $repo = $this->getRepo();
        $this->assertTrue($repo instanceof RepositoryContract);
    }

    public function testAdd() {
        $repo = $this->getRepo();
        $repo->add([
            "name" => "reyad",
            "age" => 23
        ]);
        $sql = "SELECT name, age FROM " . $repo->table();
        $stmt = $repo->conn()->query($sql);
        $count = 0;
        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->assertEquals($row["name"], "reyad");
            $this->assertEquals($row["age"], 23);
            $count++;
        }
        $this->assertEquals($count, 1);
    }

    public function testGet() {
        $repo = $this->getRepo();
        $repo->add([
            "name" => "reyad",
            "age" => 23
        ]);
        $repo->add([
            "name" => "jen",
            "age" => 23
        ]);
        $users = $repo->get();
        $this->assertEquals($users[0]->name, "reyad");
        $this->assertEquals($users[1]->name, "jen");
        $users = $repo->where("name", "reyad")->get();
        $this->assertEquals($users[0]->age, "23");
    }

    public function testUpdate() {
        $repo = $this->getRepo();
        $repo->add([
            "name" => "reyad",
            "age" => 23
        ]);
        $repo->add([
            "name" => "jen",
            "age" => 23
        ]);
        $repo->where("name", "reyad")
            ->update([
                "age" => 25
            ]);
        $users = $repo->whereRaw("name = 'reyad'")->get();
        $this->assertEquals($users[0]->age, "25");
        $users = $repo->whereRaw("name = 'jen'")
            ->where("age", 23)
            ->get();
        $this->assertEquals($users[0]->age, "23");
    }

    public function testDelete() {
        $repo = $this->getRepo();
        $repo->add([
            "name" => "reyad",
            "age" => 23
        ]);
        $repo->add([
            "name" => "jen",
            "age" => 23
        ]);
        $users = $repo->get();
        $this->assertEquals(count($users), 2);
        $repo->where("name", "reyad")->delete();
        $users = $repo->get();
        $this->assertEquals(count($users), 1);
        $this->assertEquals($users[0]->name, "jen");
    }

    public function testFind() {
        $repo = $this->getRepo();
        $repo->add([
            "name" => "reyad",
            "age" => 23
        ]);
        $repo->add([
            "name" => "jen",
            "age" => 23
        ]);
        $this->assertEquals($repo->find(1)->name, "reyad");
        $this->assertEquals($repo->find(2)->name, "jen");
    }

    public function testExists() {
        $repo = $this->getRepo();
        $repo->add([
            "name" => "jen",
            "age" => 23
        ]);
        $this->assertTrue($repo->exists(1)); // 'jen' exists as only user
        $this->assertFalse($repo->exists(2));
    }

    public function testSave() {
        $repo = $this->getRepo();
        $repo->add([
            "name" => "jen",
            "age" => 23
        ]);
        $user = new SomeModel();
        $user->assign([
            "name" => "reyad",
            "age" => 23
        ]);
        $repo->save($user);
        $users = $repo->where("name", "reyad")->get();
        $this->assertEquals($users[0]->name, "reyad");
        $jen = $repo->where("name", "jen")->get()[0];
        $jen->age = 25;
        $repo->save($jen);
        $this->assertEquals(
            $repo->where("name", "jen")
                ->get()[0]->age,
            "25"
        );
    }
}