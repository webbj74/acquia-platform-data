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

use Acquia\Platform\Cloud\Hosting\Realm;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Realm
 */
class RealmTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @dataProvider commonDataProvider()
     */
    public function testRealmCanBeInstantiatedNormally($name, $hostNameRoot, $domainNameRoot)
    {
        $realm = new Realm($name);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Realm', $realm);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\RealmInterface', $realm);
    }

    /**
     * @covers ::__construct()
     * @dataProvider invalidNameDataProvider()
     */
    public function testRealmCannotBeInstantiatedWithInvalidName($name)
    {
        $this->expectException(InvalidArgumentException::class);
        $realm = new Realm($name);
    }

    /**
     * @covers ::create()
     * @dataProvider commonDataProvider()
     */
    public function testRealmCanBeInstantiatedWithFactoryMethod($name, $hostNameRoot, $domainNameRoot)
    {
        $realm = Realm::create(['name' => $name]);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Realm', $realm);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\RealmInterface', $realm);
    }

    /**
     * @covers ::getName()
     * @dataProvider commonDataProvider()
     */
    public function testRealmCanReturnItsName($name, $hostNameRoot, $domainNameRoot)
    {
        $realm = new Realm($name);
        $this->assertEquals($name, $realm->getName());
    }

    /**
     * @covers ::getHostNameRoot()
     * @dataProvider commonDataProvider()
     */
    public function testRealmCanReturnItsHostNameRoot($name, $hostNameRoot, $domainNameRoot)
    {
        $realm = new Realm($name);
        $this->assertEquals($hostNameRoot, $realm->getHostNameRoot());
    }

    /**
     * @covers ::getDefaultSiteDomainNameRoot()
     * @dataProvider commonDataProvider()
     */
    public function testRealmCanReturnItsDefaultSiteDomainNameRoot($name, $hostNameRoot, $domainNameRoot)
    {
        $realm = new Realm($name);
        $this->assertEquals($domainNameRoot, $realm->getDefaultSiteDomainNameRoot());
    }

    /**
     * @covers ::__toString()
     * @dataProvider commonDataProvider()
     */
    public function testRealmCanBeAccessedAsString($name, $hostNameRoot, $domainNameRoot)
    {
        $realm = new Realm($name);
        $this->assertEquals($name, (string) $realm);
    }

    /**
     * @covers ::setDefault()
     * @covers ::isDefault()
     */
    public function testRealmCanBeLabeledDefault()
    {
        $realm = new Realm('test1');
        $this->assertFalse($realm->isDefault());
        $realm->setDefault(true);
        $this->assertTrue($realm->isDefault());
        $realm->setDefault(false);
        $this->assertFalse($realm->isDefault());
    }

    public function commonDataProvider()
    {
        return array(
            'test1' => ['test1', 'test1.hosting.acquia.com', 'test1.acquia-sites.com'],
            'test2' => ['test2', 'test2.hosting.acquia.com', 'test2.acquia-sites.com'],
            'test-3' => ['test-3', 'test-3.hosting.acquia.com', 'test-3.acquia-sites.com'],
        );
    }

    public function invalidNameDataProvider()
    {
        return [
            'space' => ['test 1'],
            'empty string' => [''],
            'NULL' => [null],
        ];
    }
}
