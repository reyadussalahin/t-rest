<?php

namespace App;


use HelloWorld\App\App as HelloWorldApp;


class App extends HelloWorldApp {
    public function __construct($base, $globals) {
        parent::__construct($base, $globals);
    }
}