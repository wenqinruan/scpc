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

    public function testFetchAll()
    {
        $connection = new Connection();
        $connection->setServerHost('127.0.0.1');
        $connection->setServerPort('9501');

        $result = $connection->fetchAll('SELECT * FROM user ');

        $this->assertTrue(is_array($result));
    }

    public function testTransction()
    {
        $connection = new Connection();
        $connection->setServerHost('127.0.0.1');
        $connection->setServerPort('9501');

        $connection->beginTransaction();
        
        $fakeUser = array(
            'nickname' => 'zhangsna',
            'email' => '452253895@qq.com123',
            'password' => 'abc',
            'salt' => 'aaacccdd',
            'type' => 'default',
            'roles' => 'admin'
        );
        $connection->insert('user', $fakeUser);
        $lastId = $connection->lastInsertId();
        $user = $connection->fetchAssoc('SELECT * FROM USER WHERE id='.$lastId);
        $this->assertEquals('zhangsna', $user['nickname']);

        $connection->rollback();
    }
}
