<?php

use PHPUnit\Framework\TestCase;
use HelloWorld\Contracts\App\App as AppContract;
use App\App;


class AppTest extends TestCase {
    public function testContract() {
        $app = new App(null, null);
        $this->assertEquals(true, $app instanceof AppContract);
    }
}