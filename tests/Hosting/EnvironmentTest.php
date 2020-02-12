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

use Acquia\Platform\Cloud\Hosting\Environment;
use Acquia\Platform\Cloud\Hosting\Server;
use Acquia\Platform\Cloud\Hosting\Server\ServerList;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Environment
 */
class EnvironmentTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @dataProvider commonDataProvider()
     */
    public function testRealmCanBeInstantiatedNormally($envName)
    {
        $environment = new Environment($envName);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Environment', $environment);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\EnvironmentInterface', $environment);
    }

    /**
     * @covers ::__construct()
     * @dataProvider invalidNameDataProvider()
     */
    public function testRealmCannotBeInstantiatedWithInvalidName($envName)
    {
        $this->expectException(InvalidArgumentException::class);
        $environment = new Environment($envName);
    }

    /**
     * @covers ::create()
     * @dataProvider commonDataProvider()
     */
    public function testRealmCanBeInstantiatedWithFactoryMethod($envName)
    {
        $environment = Environment::create(
            [
                'name' => $envName,
                'vcs_path' => 'tags/WELCOME',
                'ssh_host' => 'srv-1234.test',
                'db_clusters' => [123],
                'default_domain' => 'myappf4f4f5g.test',
                'livedev' => 'disabled',
                'unix_username' => 'myapp.' . $envName,
            ]
        );
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Environment', $environment);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\EnvironmentInterface', $environment);
        $this->assertEquals('myappf4f4f5g', $environment->getMachineName());
        $this->assertFalse($environment->isInLiveDev());
    }

    /**
     * @covers ::getName
     * @dataProvider commonDataProvider()
     */
    public function testNamePropertyMayBeAccessedViaMethods($envName)
    {
        $environment = new Environment($envName);
        $this->assertEquals($envName, $environment->getName());
    }

    /**
     * @covers ::getRevision
     * @covers ::setRevision
     */
    public function testRevisionPropertyMayBeAccessedViaMethods()
    {
        $environment = new Environment('test');
        $revisions = [
            'tags/tagname',
            'branchname',
        ];
        foreach ($revisions as $revision) {
            $environment->setRevision($revision);
            $this->assertEquals($revision, $environment->getRevision());
        }
    }

    /**
     * @covers ::getRevision
     */
    public function testRevisionPropertyWhenUnset()
    {
        $this->expectException(RuntimeException::class);
        $environment = new Environment('test');
        $environment->getRevision();
    }

    /**
     * @covers ::setRevision
     * @dataProvider nullDataProvider()
     */
    public function testRevisionPropertyRejectsNullValue($value)
    {
        $this->expectException(InvalidArgumentException::class);
        $environment = new Environment('test');
        $environment->setRevision($value);
    }

    /**
     * @covers ::getDefaultHostName
     * @covers ::setDefaultHostName
     */
    public function testDefaultHostNamePropertyMayBeAccessedViaMethods()
    {
        $environment = new Environment('test');
        $hosts = [
            'web-123.test',
            'staging-456.test',
        ];
        foreach ($hosts as $host) {
            $environment->setDefaultHostName($host);
            $this->assertEquals($host, $environment->getDefaultHostName());
        }
    }

    /**
     * @covers ::getDefaultHostName
     */
    public function testDefaultHostNamePropertyWhenUnset()
    {
        $this->expectException(RuntimeException::class);
        $environment = new Environment('test');
        $environment->getDefaultHostName();
    }

    /**
     * @covers ::setDefaultHostName
     * @dataProvider nonStringProvider()
     */
    public function testDefaultHostNamePropertyRejectsNonString($value)
    {
        $this->expectException(InvalidArgumentException::class);
        $environment = new Environment('test');
        $environment->setDefaultHostName($value);
    }

    /**
     * @covers ::getDatabaseClusterList
     * @covers ::setDatabaseClusterList
     */
    public function testDatabaseClusterListPropertyMayBeAccessedViaMethods()
    {
        $environment = new Environment('test');
        $clusterLists = [
            [1234],
            [5678],
        ];
        foreach ($clusterLists as $clusterList) {
            $environment->setDatabaseClusterList($clusterList);
            $this->assertEquals($clusterList, $environment->getDatabaseClusterList());
        }
    }

    /**
     * @covers ::getDatabaseClusterList
     */
    public function testDatabaseClusterListPropertyWhenUnset()
    {
        $this->expectException(RuntimeException::class);
        $environment = new Environment('test');
        $environment->getDatabaseClusterList();
    }

    /**
     * @covers ::getDefaultDomainName
     * @covers ::setDefaultDomainName
     */
    public function testDefaultDomainNamePropertyMayBeAccessedViaMethods()
    {
        $environment = new Environment('test');
        $domains = [
            'test.local',
            'example.com',
        ];
        foreach ($domains as $domain) {
            $environment->setDefaultDomainName($domain);
            $this->assertEquals($domain, $environment->getDefaultDomainName());
        }
    }

    /**
     * @covers ::getDefaultDomainName
     */
    public function testDefaultDomainNamePropertyWhenUnset()
    {
        $this->expectException(RuntimeException::class);
        $environment = new Environment('test');
        $environment->getDefaultDomainName();
    }

    /**
     * @covers ::setDefaultDomainName
     * @dataProvider nonStringProvider()
     */
    public function testDefaultDomainNamePropertyRejectsNonString($value)
    {
        $this->expectException(InvalidArgumentException::class);
        $environment = new Environment('test');
        $environment->setDefaultDomainName($value);
    }

    /**
     * @covers ::isInLiveDev
     * @covers ::setInLiveDev
     */
    public function testInLiveDevPropertyMayBeAccessedViaMethods()
    {
        $environment = new Environment('test');
        $devModes = [
            false,
            true,
        ];
        foreach ($devModes as $devMode) {
            $environment->setInLiveDev($devMode);
            $this->assertEquals($devMode, $environment->isInLiveDev());
        }
    }

    /**
     * @covers ::isInLiveDev
     */
    public function testInLiveDevPropertyWhenUnset()
    {
        $this->expectException(RuntimeException::class);
        $environment = new Environment('test');
        $environment->isInLiveDev();
    }

    /**
     * @covers ::setInLiveDev
     * @dataProvider nonBoolProvider()
     */
    public function testInLiveDevPropertyRejectsNonBool($value)
    {
        $this->expectException(InvalidArgumentException::class);
        $environment = new Environment('test');
        $environment->setInLiveDev($value);
    }

    /**
     * @covers ::getUnixUserName
     * @covers ::setUnixUserName
     */
    public function testUnixUserNamePropertyMayBeAccessedViaMethods()
    {
        $environment = new Environment('test');
        $users = [
            'myapp.dev',
            'myapp.test',
            'myapp.prod',
        ];
        foreach ($users as $user) {
            $environment->setUnixUserName($user);
            $this->assertEquals($user, $environment->getUnixUserName());
        }
    }

    /**
     * @covers ::getUnixUserName
     */
    public function testUnixUserNamePropertyWhenUnset()
    {
        $this->expectException(RuntimeException::class);
        $environment = new Environment('test');
        $environment->getUnixUserName();
    }

    /**
     * @covers ::setUnixUserName
     * @dataProvider nonStringProvider()
     */
    public function testUnixUserNamePropertyRejectsNonString($value)
    {
        $this->expectException(InvalidArgumentException::class);
        $environment = new Environment('test');
        $environment->setUnixUserName($value);
    }

    /**
     * @covers ::getMachineName
     * @covers ::setMachineName
     */
    public function testMachineNamePropertyMayBeAccessedViaMethods()
    {
        $environment = new Environment('test');
        $machineNames = [
            'myappdev',
            'myappstg',
            'myappf4f4f5g',
        ];
        foreach ($machineNames as $machineName) {
            $environment->setMachineName($machineName);
            $this->assertEquals($machineName, $environment->getMachineName());
        }
    }

    /**
     * @covers ::getMachineName
     */
    public function testMachineNamePropertyWhenUnset()
    {
        $this->expectException(RuntimeException::class);
        $environment = new Environment('test');
        $environment->getMachineName();
    }

    /**
     * @covers ::setMachineName
     * @dataProvider nonStringProvider()
     */
    public function testMachineNamePropertyRejectsNonString($value)
    {
        $this->expectException(InvalidArgumentException::class);
        $environment = new Environment('test');
        $environment->setMachineName($value);
    }

    /**
     * @covers ::getServerList
     * @covers ::setServerList
     */
    public function testServerListPropertyMayBeAccessedViaMethods()
    {
        $environment = new Environment('test');
        $serverList = new ServerList();
        $serverList->append(new Server('srv-123'));
        $environment->setServerList($serverList);
        $this->assertEquals('srv-123', $environment->getServerList()->offsetGet(0)->getName());
    }

    /**
     * @covers ::getMachineName
     */
    public function testServerListPropertyWhenUnset()
    {
        $this->expectException(RuntimeException::class);
        $environment = new Environment('test');
        $environment->getServerList();
    }

    /**
     * @covers ::getApplicationQualifiedName
     */
    public function testCanReturnApplicationQualifiedName()
    {
        $environment = new Environment('test');
        $users = [
            'myapp.dev',
            'myapp.test',
            'myapp.prod',
        ];
        foreach ($users as $user) {
            $environment->setUnixUserName($user);
            $this->assertEquals($user, $environment->getApplicationQualifiedName());
        }
    }

    /**
     * @covers ::getDocumentRootPath
     */
    public function testCanReturnDocumentRootPath()
    {
        $environment = new Environment('test');
        $environment->setUnixUserName('test.prod');
        $environment->setInLiveDev(false);
        $this->assertEquals('/var/www/html/test.prod/docroot', $environment->getDocumentRootPath());
        $environment->setInLiveDev(true);
        $this->assertEquals('/mnt/gfs/test.prod/livedev/docroot', $environment->getDocumentRootPath());
    }

    public function commonDataProvider()
    {
        return array(
            'prod' => ['prod'],
            'test' => ['test'],
            'dev' => ['dev'],
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

    public function nonBoolProvider()
    {
        return [
            'empty string' => [''],
            'NULL' => [null],
        ];
    }

    public function nonStringProvider()
    {
        return [
            'empty string' => [''],
            'NULL' => [null],
        ];
    }

    public function nullDataProvider()
    {
        return [
            'NULL' => [null],
        ];
    }
}
