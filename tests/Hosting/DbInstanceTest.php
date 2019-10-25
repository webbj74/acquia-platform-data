<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting;

use Acquia\Platform\Cloud\Hosting\DbInstance;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\DbInstance
 */
class DbInstanceTest extends TestCase
{
    /**
     * Data provider of valid instance names.
     *
     * @return array
     */
    public function instanceNameDataProvider()
    {
        return [
            ['foo'],
            ['Bar01'],
            ['Baz_02'],
            ['qux_Foo_3'],
            ['4BarBaz_321'],
            ['55_qux'],
            ['foo_bar_baz'],
        ];
    }

    /**
     * @dataProvider instanceNameDataProvider
     * @covers ::__construct
     * @covers ::getInstanceName
     * @param string $instanceName A valid db instance name.
     */
    public function testInstanceNamePropertyMayBeAccessedViaMethods($instanceName)
    {
        $dbInstance = new DbInstance($instanceName);
        $this->assertEquals($instanceName, $dbInstance->getInstanceName());
    }

    /**
     * Data provider of invalid instance names.
     *
     * @return array
     */
    public function invalidInstanceNameDataProvider()
    {
        return [
            [''],
            [' '],
            [[]],
            ['*foo*'],
            ['9'],
            ['88'],
            ['_foo'],
        ];
    }

    /**
     * @dataProvider invalidInstanceNameDataProvider
     * @covers ::__construct
     * @param mixed $instanceName An invalid db instance name.
     */
    public function testInstanceNamePropertyMustBeAnAlphanumericString($instanceName)
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance($instanceName);
    }

    /**
     * @covers ::create()
     */
    public function testDbInstanceCanBeInstantiatedWithFactoryMethod()
    {
        $dbInstance = DbInstance::create(['instance_name' => 'db1234']);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\DbInstance', $dbInstance);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\DbInstanceInterface', $dbInstance);

        $dbInstance = DbInstance::create(
            [
                'instance_name' => 'db1234',
                'name' => 'dev',
                'username' => 'user',
                'password' => 'hunter2',
                'host' => 'staging-1234',
                'db_cluster' => '1234',
            ]
        );
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\DbInstance', $dbInstance);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\DbInstanceInterface', $dbInstance);
    }

    /**
     * @covers ::getName
     * @covers ::setName
     */
    public function testNamePropertyMayBeAccessedViaMethods()
    {
        $name = 'dev';
        $dbInstance = new DbInstance('test');
        $dbInstance->setName($name);
        $this->assertEquals($name, $dbInstance->getName());
    }

    /**
     * @covers ::getName
     */
    public function testGetNameWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->getName();
    }

    /**
     * @covers ::setName
     */
    public function testSetNameWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setName([]);
    }

    /**
     * @covers ::setName
     */
    public function testSetNameWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setName('');
    }

    /**
     * @covers ::getUsername
     * @covers ::setUsername
     */
    public function testUsernamePropertyMayBeAccessedViaMethods()
    {
        $username = 'user';
        $dbInstance = new DbInstance('test');
        $dbInstance->setUsername($username);
        $this->assertEquals($username, $dbInstance->getUsername());
    }

    /**
     * @covers ::getUsername
     */
    public function testGetUsernameWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->getUsername();
    }

    /**
     * @covers ::setUsername
     */
    public function testSetUsernameWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setUsername([]);
    }

    /**
     * @covers ::setUsername
     */
    public function testSetUsernameWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setUsername('');
    }

    /**
     * @covers ::getPassword
     * @covers ::setPassword
     */
    public function testPasswordPropertyMayBeAccessedViaMethods()
    {
        $password = 'hunter2';
        $dbInstance = new DbInstance('test');
        $dbInstance->setPassword($password);
        $this->assertEquals($password, $dbInstance->getPassword());
    }

    /**
     * @covers ::getPassword
     */
    public function testGetPasswordWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->getPassword();
    }

    /**
     * @covers ::setPassword
     */
    public function testSetPasswordWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setPassword([]);
    }

    /**
     * @covers ::setPassword
     */
    public function testSetPasswordWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setPassword('');
    }

    /**
     * @covers ::getHost
     * @covers ::setHost
     */
    public function testHostPropertyMayBeAccessedViaMethods()
    {
        $host = 'staging-123';
        $dbInstance = new DbInstance('test');
        $dbInstance->setHost($host);
        $this->assertEquals($host, $dbInstance->getHost());
    }

    /**
     * @covers ::getHost
     */
    public function testGetHostWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->getHost();
    }

    /**
     * @covers ::setHost
     */
    public function testSetHostWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setHost([]);
    }

    /**
     * @covers ::setHost
     */
    public function testSetHostWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setHost('');
    }

    /**
     * @covers ::getClusterID
     * @covers ::setClusterID
     */
    public function testClusterIDPropertyMayBeAccessedViaMethods()
    {
        $clusterID = 'staging-123';
        $dbInstance = new DbInstance('test');
        $dbInstance->setClusterID($clusterID);
        $this->assertEquals($clusterID, $dbInstance->getClusterID());
    }

    /**
     * @covers ::getClusterID
     */
    public function testGetClusterIDWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->getClusterID();
    }

    /**
     * @covers ::setClusterID
     */
    public function testSetClusterIDWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setClusterID([]);
    }

    /**
     * @covers ::setClusterID
     */
    public function testSetClusterIDWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbInstance = new DbInstance('test');
        $dbInstance->setClusterID('');
    }
}
