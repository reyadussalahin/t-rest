<?php

namespace App\Contracts\Database\Models;


interface Model {
    public function id();
    public function string($fieldName, $default=null);
    public function int($fieldName, $default=null);
    public function assign($modelData);
    public function __set($fieldName, $value);
    public function __get($fieldName);
    public function set($fieldName, $value);
    public function get($fieldName);
    public function getType($fieldName);
    public function getAll();
}