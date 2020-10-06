<?php

use PHPUnit\Framework\TestCase;
use HelloWorld\Contracts\App\App as AppContract;
use App\App;
use App\Contracts\Database\Database as DatabaseContract;


class AppTest extends TestCase {
    public function testContract() {
        $app = new App(null, null);
        $this->assertEquals(true, $app instanceof AppContract);
    }

    public function testDb() {
        $base = __DIR__ . "/../..";
        $app = new App($base, null);
        $db = $app->db();
        $this->assertTrue($db instanceof DatabaseContract);
    }
}