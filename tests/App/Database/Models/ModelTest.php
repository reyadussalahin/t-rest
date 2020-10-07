<?php

namespace Tests\App\Database\Models;


use PHPUnit\Framework\TestCase;
use App\Contracts\Database\Models\Model as ModelContract;
use App\Database\Models\Model;


class ModelTest extends TestCase {
    public function testContract() {
        $model = new Model();
        $this->assertTrue($model instanceof ModelContract);
    }

    public function testId() {
        $model = new Model();
        $model->id();
        $this->assertEquals(
            $model->getAll()["id"]["type"],
            "int"
        );
    }

    public function testString() {
        $model = new Model();
        $model->string("name");
        $this->assertEquals(
            $model->getAll()["name"]["type"],
            "text"
        );
        $this->assertEquals(
            $model->getAll()["name"]["value"],
            null
        );
    }

    public function testInt() {
        $model = new Model();
        $model->int("age");
        $this->assertEquals(
            $model->getAll()["age"]["type"],
            "int"
        );
        $this->assertEquals(
            $model->getAll()["age"]["value"],
            null
        );
    }

    public function testAssign() {
        $model = new Model();
        $model->string("name");
        $model->int("age");
        $model->assign([
            "name" => "reyad",
            "age" => 23
        ]);
        $this->assertEquals(
            $model->getAll()["name"]["type"],
            "text"
        );
        $this->assertEquals(
            $model->getAll()["name"]["value"],
            "reyad"
        );
        $this->assertEquals(
            $model->getAll()["age"]["type"],
            "int"
        );
        $this->assertEquals(
            $model->getAll()["age"]["value"],
            23
        );
    }

    public function test__set() {
        $model = new Model();
        $model->string("name");
        $model->name = "reyad";
        $this->assertEquals(
            $model->getAll()["name"]["type"],
            "text"
        );
        $this->assertEquals(
            $model->getAll()["name"]["value"],
            "reyad"
        );
    }

    public function test__get() {
        $model = new Model();
        $model->string("name");
        $model->name = "reyad";
        $this->assertEquals(
            $model->name,
            "reyad"
        );
    }

    public function testSet() {
        $model = new Model();
        $model->string("name");
        $model->int("age");
        $model->set("name", "reyad");
        $model->set("age", 23);
        $this->assertEquals(
            $model->name,
            "reyad"
        );
        $this->assertEquals(
            $model->age,
            23
        );
    }

    public function testGet() {
        $model = new Model();
        $model->string("name");
        $model->int("age");
        $model->name = "reyad";
        $model->age = 23;
        $this->assertEquals(
            $model->get("name"),
            "reyad"
        );
        $this->assertEquals(
            $model->get("age"),
            23
        );
    }

    public function testGetType() {
        $model = new Model();
        $model->string("name");
        $model->int("age");
        $this->assertEquals(
            $model->getType("name"),
            "text"
        );
        $this->assertEquals(
            $model->getType("age"),
            "int"
        );
    }

    public function testGetAll() {
        $model = new Model();
        $model->string("name");
        $model->int("age");
        $model->name = "reyad";
        $model->age = 23;
        $all = $model->getAll();
        $this->assertEquals(
            $all["name"]["value"],
            "reyad"
        );
        $this->assertEquals(
            $all["age"]["value"],
            23
        );
    }
}