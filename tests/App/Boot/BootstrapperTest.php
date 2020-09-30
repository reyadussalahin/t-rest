<?php

use PHPUnit\Framework\TestCase;
use App\Boot\Bootstrapper;

class BootstrapperTest extends TestCase {
    public function testLoad() {
        $bootstrapper = new Bootstrapper();
        $this->assertEquals("loaded", $bootstrapper->load());
    }
}