<?php

namespace App\Database\Models;


use App\Database\Models\Model;


class User extends Model {
    public function __construct() {
        $this->id()
            ->string("username")
            ->string("email")
            ->string("password");
    }
}