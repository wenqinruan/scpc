<?php

namespace Codeages\SCPC\Test;

use Codeages\SCPC\Connection;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $cnnection = new Connection();
        $this->assertTrue($cnnection instanceof Connection);
    }
}
