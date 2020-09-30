<?php

require __DIR__ . "/../vendor/autoload.php";


$bootstrapper = new \App\Boot\Bootstrapper();
$bootstrapper->load();

$app = new \App\App(
    dirname(__DIR__),
    new \HelloWorld\App\Globals()
);

$response = $app->process();

$response->send();