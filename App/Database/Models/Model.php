<?php

namespace App\Database\Models;


use App\Contracts\Database\Models\Model as ModelContract;


class Model implements ModelContract {
    private $fields;

    public function id() {
        $this->fields["id"] = [
            "type" => "int"
        ];
        return $this;
    }

    public function string($fieldName, $default=null) {
        $this->fields[$fieldName] = [
            "type" => "text",
            "value" => $default
        ];
        return $this;
    }

    public function int($fieldName, $default=null) {
        $this->fields[$fieldName] = [
            "type" => "int",
            "value" => $default
        ];
        return $this;
    }

    public function assign($modelData) {
        foreach($modelData as $fieldName => $value) {
            if(isset($this->fields[$fieldName])) {
                $this->fields[$fieldName]["value"] = $value;
            } else {
                throw new \Exception(
                    "Error: column \"" . $fieldName . "\" not found",
                    1
                );
            }
        }
        return $this;
    }

    public function __set($fieldName, $value) {
        if(!isset($this->fields[$fieldName])) {
            throw new \Exception(
                "Error: column \"" . $fieldName . "\" not found",
                1
            );
        }
        $this->fields[$fieldName]["value"] = $value;
        return $value;
    }

    public function __get($fieldName) {
        if(!isset($this->fields[$fieldName])) {
            throw new \Exception(
                "Error: column \"" . $fieldName . "\" not found",1
            );
        }
        return $this->fields[$fieldName]["value"];
    }

    public function set($fieldName, $value) {
        if(!isset($this->fields[$fieldName])) {
            throw new \Exception(
                "Error: column \"" . $fieldName . "\" not found",
                1
            );
        }
        $this->fields[$fieldName]["value"] = $value;
        return $this;
    }

    public function get($fieldName) {
        if(!isset($this->fields[$fieldName])) {
            throw new \Exception(
                "Error: column \"" . $fieldName . "\" not found",
                1
            );
        }
        return $this->fields[$fieldName]["value"];
    }

    public function getType($fieldName) {
        if(!isset($this->fields[$fieldName])) {
            throw new \Exception(
                "Error: column \"" . $fieldName . "\" not found",1
            );
        }
        return $this->fields[$fieldName]["type"];
    }

    public function getAll() {
        return $this->fields;
    }
}