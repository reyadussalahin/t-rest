<?php

namespace App\Http\Controllers;


use HelloWorld\App\Controllers\Controller;


class HomeController extends Controller {
    public function __construct($app) {
        parent::__construct($app);
    }

    public function index() {
        return $this->app->text("this is index");
    }
}