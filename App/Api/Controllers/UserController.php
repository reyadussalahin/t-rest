<?php

namespace App\Api\Controllers;


use HelloWorld\App\Controllers\Controller;
use App\Database\Repositories\UserRepository;


class UserController extends Controller {
    public function __construct($app) {
        parent::__construct($app);
    }

    public function index() {
        $repo = new UserRepository($this->app);
        $users = $repo->get();
        $all = [];
        foreach($users as $user) {
            $all[] = $user->get();
        }
        return $this->app->text(
            json_encode($all)
        );
    }

    public function show($id) {
        $repo = new UserRepository($this->app);
        $user = $repo->find($id);
        if($user === null) {
            return json_encode(array());
        }
        return $this->app->text(
            json_encode($user->get())
        );
    }

    public function store() {
        $request = json_decode(file_get_contents("php://input"), true);

        if(!isset($request["username"])
            || !isset($request["email"])
            || !isset($request["password"])
        ) {
            return $this->app->text(
                "Error: User data is not provided properly."
            );
        }
        $repo = new UserRepository($this->app);
        $repo->add([
            "username" => $request["username"],
            "email" => $request["email"],
            "password" => $request["password"]
        ]);
        return $this->app->text(
            json_encode([
                "status" => "success"
            ])
        );
    }

    public function update($id) {
        $repo = new UserRepository($this->app);
        $user = $repo->find($id);
        if($user === null) {
            return $this->app->text(
                json_encode([
                    "status" => "failure",
                    "msg" => "no such user exists"
                ])
            );
        }
        $request = json_decode(file_get_contents("php://input"), true);
        if(isset($request["username"])) {
            $user->username = $request["username"];
        }
        if(isset($request["email"])) {
            $user->email = $request["email"];
        }
        if(isset($request["password"])) {
            $user->password = $request["password"];
        }
        $repo->save($user);
        return $this->app->text(
            json_encode([
                "status"=> "success"
            ])
        );
    }

    public function delete($id) {
        $repo = new UserRepository($this->app);
        $repo->where("id", $id)->delete();
        return $this->app->text(
            json_encode([
                "status"=> "success"
            ])
        );
    }
}