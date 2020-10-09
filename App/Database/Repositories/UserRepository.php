<?php

namespace App\Database\Repositories;


use App\Database\Repositories\Repository;
use App\Database\Models\User;


class UserRepository extends Repository {
    public function __construct($app) {
        parent::__construct($app);
    }

    public function model() {
        return User::class;
    }

    public function table() {
        return "users";
    }
}