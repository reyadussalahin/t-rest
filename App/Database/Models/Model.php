<?php

namespace App\Database\Models;


use App\Contracts\Database\Models\Model as ModelContract;


class Model implements ModelContract {
    private $fields;
    private $types;

    private function &types() {
        if($this->types === null) {
            $this->types = [];
        }
        return $this->types;
    }

    private function &fields() {
        if($this->fields === null) {
            $this->fields = [];
        }
        return $this->fields;
    }

    public function id() {
        $this->types()["id"] = "int";
        $this->fields()["id"] = "serial";
        return $this;
    }

    public function string($fieldName, $default=null) {
        $this->types()[$fieldName] = "text";
        $this->fields()[$fieldName] = $default;
        return $this;
    }

    public function int($fieldName, $default=null) {
        $this->types()[$fieldName] = "int";
        $this->fields()[$fieldName] = $default;
        return $this;
    }

    public function assign($modelData) {
        foreach($this->fields() as $fieldName => &$value) {
            if(isset($modelData[$fieldName])) {
                $value = $modelData[$fieldName];
            }
        }
        return $this;
    }

    public function __set($fieldName, $value) {
        $this->fields()[$fieldName] = $value;
        return $value;
    }

    public function __get($fieldName) {
        return $this->fields()[$fieldName];
    }

    public function set($fieldName, $value) {
        $this->fields()[$fieldName] = $value;
        return $this;
    }

    public function get($fieldName=null) {
        if($fieldName === null) {
            return $this->fields();
        }
        return $this->fields()[$fieldName];
    }

    public function type($fieldName) {
        return $this->types()[$fieldName];
    }
}