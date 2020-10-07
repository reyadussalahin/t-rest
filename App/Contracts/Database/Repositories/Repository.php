<?php

namespace App\Contracts\Database\Repositories;


interface Repository {
    public function model();
    public function table();
    public function conn();
    public function add($modelData);
    public function whereRaw($filterString);
    public function where($fieldName, $value);
    public function get();
    public function update($updates);
    public function delete();
    public function find($id);
}