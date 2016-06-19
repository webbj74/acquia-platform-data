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

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Environment
 */
class EnvironmentTest extends \PHPUnit_Framework_TestCase
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
     * @expectedException \InvalidArgumentException
     */
    public function testRealmCannotBeInstantiatedWithInvalidName($envName)
    {
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
     * @expectedException \RuntimeException
     */
    public function testRevisionPropertyWhenUnset()
    {
        $environment = new Environment('test');
        $environment->getRevision();
    }

    /**
     * @covers ::setRevision
     * @dataProvider nonStringProvider()
     * @expectedException \InvalidArgumentException
     */
    public function testRevisionPropertyRejectsNonString($value)
    {
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
     * @expectedException \RuntimeException
     */
    public function testDefaultHostNamePropertyWhenUnset()
    {
        $environment = new Environment('test');
        $environment->getDefaultHostName();
    }

    /**
     * @covers ::setDefaultHostName
     * @dataProvider nonStringProvider()
     * @expectedException \InvalidArgumentException
     */
    public function testDefaultHostNamePropertyRejectsNonString($value)
    {
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
     * @expectedException \RuntimeException
     */
    public function testDatabaseClusterListPropertyWhenUnset()
    {
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
     * @expectedException \RuntimeException
     */
    public function testDefaultDomainNamePropertyWhenUnset()
    {
        $environment = new Environment('test');
        $environment->getDefaultDomainName();
    }

    /**
     * @covers ::setDefaultDomainName
     * @dataProvider nonStringProvider()
     * @expectedException \InvalidArgumentException
     */
    public function testDefaultDomainNamePropertyRejectsNonString($value)
    {
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
     * @expectedException \RuntimeException
     */
    public function testInLiveDevPropertyWhenUnset()
    {
        $environment = new Environment('test');
        $environment->isInLiveDev();
    }

    /**
     * @covers ::setInLiveDev
     * @dataProvider nonBoolProvider()
     * @expectedException \InvalidArgumentException
     */
    public function testInLiveDevPropertyRejectsNonBool($value)
    {
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
     * @expectedException \RuntimeException
     */
    public function testUnixUserNamePropertyWhenUnset()
    {
        $environment = new Environment('test');
        $environment->getUnixUserName();
    }

    /**
     * @covers ::setUnixUserName
     * @dataProvider nonStringProvider()
     * @expectedException \InvalidArgumentException
     */
    public function testUnixUserNamePropertyRejectsNonString($value)
    {
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
     * @expectedException \RuntimeException
     */
    public function testMachineNamePropertyWhenUnset()
    {
        $environment = new Environment('test');
        $environment->getMachineName();
    }

    /**
     * @covers ::setMachineName
     * @dataProvider nonStringProvider()
     * @expectedException \InvalidArgumentException
     */
    public function testMachineNamePropertyRejectsNonString($value)
    {
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
     * @expectedException \RuntimeException
     */
    public function testServerListPropertyWhenUnset()
    {
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
}
