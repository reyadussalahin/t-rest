<?php

use App\Api\Controllers\UserController;


return [
    "GET" => [
        "/users" => [
            "name" => "users",
            "target" => [UserController::class, "index"]
        ],
        "/user/{id}" => [
            "name" => "user.show",
            "target" => [UserController::class, "show"],
            "filter" => [
                "id" => "[0-9]+"
            ]
        ]
    ],

    "POST" => [
        "/user" => [
            "name" => "user.store",
            "target" => [UserController::class, "store"]
        ]
    ],

    "PATCH" => [
        "/user/{id}" => [
            "name" => "user.update",
            "target" => [UserController::class, "update"],
            "filter" => [
                "id" => "[0-9]+"
            ]
        ]
    ],

    "DELETE" => [
        "/user/{id}" => [
            "name" => "user.delete",
            "target" => [UserController::class, "delete"],
            "filter" => [
                "id" => "[0-9]+"
            ]
        ]
    ]
];