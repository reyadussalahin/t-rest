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
            $model->type("id"),
            "int"
        );
    }

    public function testString() {
        $model = new Model();
        $model->string("name");
        $this->assertEquals(
            $model->type("name"),
            "text"
        );
        $this->assertEquals(
            $model->get("name"),
            null
        );
    }

    public function testInt() {
        $model = new Model();
        $model->int("age");
        $this->assertEquals(
            $model->type("age"),
            "int"
        );
        $this->assertEquals(
            $model->get("age"),
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
            $model->type("name"),
            "text"
        );
        $this->assertEquals(
            $model->get("name"),
            "reyad"
        );
        $this->assertEquals(
            $model->type("age"),
            "int"
        );
        $this->assertEquals(
            $model->get("age"),
            23
        );
    }

    public function test__set() {
        $model = new Model();
        $model->string("name");
        $model->name = "reyad";
        $this->assertEquals(
            $model->type("name"),
            "text"
        );
        $this->assertEquals(
            $model->get("name"),
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

    public function testType() {
        $model = new Model();
        $model->string("name");
        $model->int("age");
        $model->name = "reyad";
        $model->age = 23;
        $this->assertEquals(
            $model->type("name"),
            "text"
        );
        $this->assertEquals(
            $model->type("age"),
            "int"
        );
        $fields = $model->get();
        $this->assertEquals(
            $fields["name"],
            "reyad"
        );
        $this->assertEquals(
            $fields["age"],
            23
        );
    }
}