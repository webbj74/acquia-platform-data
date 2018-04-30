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

use Acquia\Platform\Cloud\Hosting\Application;
use Acquia\Platform\Cloud\Hosting\Environment;
use Acquia\Platform\Cloud\Hosting\Environment\EnvironmentList;
use Acquia\Platform\Cloud\Hosting\Realm;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Application
 */
class ApplicationTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getRealmQualifiedName
     */
    public function testNamePropertyMayBeAccessedViaMethods()
    {
        $application = new Application('test');
        $this->assertEquals('test', $application->getName());
        $application->setRealm(new Realm('foo'));
        $this->assertEquals('foo:test', $application->getRealmQualifiedName());
    }

    /**
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getRealmQualifiedName
     */
    public function testNamePropertyMayContainUnderscores()
    {
        $application = new Application('test_sf');
        $this->assertEquals('test_sf', $application->getName());
        $application->setRealm(new Realm('foo'));
        $this->assertEquals('foo:test_sf', $application->getRealmQualifiedName());
    }

    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testNamePropertyMustBeAString()
    {
        $application = new Application([]);
    }

    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testNamePropertyMustBeAnAlphanumericString()
    {
        $application = new Application(' ');
    }

    /**
     * @covers ::create()
     */
    public function testApplicationCanBeInstantiatedWithFactoryMethod()
    {
        $app = Application::create(['name' => 'sitegroup']);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Application', $app);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\ApplicationInterface', $app);

        $app = Application::create(
            [
                'name' => 'application',
                'production_mode' => 1,
                'realm' => new Realm('realm1'),
                'environments' => new EnvironmentList([new Environment('environment1')]),
                'title' => 'My Site',
                'unix_username' => 'application',
                'uuid' => 'd2e64aca-a1de-492e-ab9e-e2866555760d',
                'vcs_type' => 'git',
                'vcs_url' => 'git@github.com:webbj74/acquia-platform-cloud-data-model.git',
            ]
        );
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Application', $app);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\ApplicationInterface', $app);
    }

    /**
     * @covers ::getVcsType
     * @covers ::setVcsType
     */
    public function testVcsTypePropertyMayBeAccessedViaMethods()
    {
        $application = new Application('test');
        foreach (['git', 'svn'] as $vcs) {
            $application->setVcsType($vcs);
            $this->assertEquals($vcs, $application->getVcsType());
        }
    }

    /**
     * @covers ::getVcsType
     * @expectedException \RuntimeException
     */
    public function testGetVcsTypeWillThrowExceptionIfPropertyNotSet()
    {
        $application = new Application('test');
        $application->getVcsType();
    }

    /**
     * @covers ::setVcsType
     * @expectedException \InvalidArgumentException
     */
    public function testSetVcsTypeWillThrowExceptionIfNotAString()
    {
        $application = new Application('test');
        $application->setVcsType([]);
    }

    /**
     * @covers ::setVcsType
     * @expectedException \InvalidArgumentException
     */
    public function testSetVcsTypeWillThrowExceptionIfEmptyString()
    {
        $application = new Application('test');
        $application->setVcsType('');
    }

    /**
     * @covers ::getVcsRepositoryUrl
     * @covers ::setVcsRepositoryUrl
     */
    public function testVcsRepositoryUrlPropertyMayBeAccessedViaMethods()
    {
        $application = new Application('test');
        $vcsUrls = [
            'https://vcs-123.prod.hosting.acquia.com/myapp',
            'examplecom@vcs-456.devcloud.hosting.acquia.com:examplecom.git',
        ];
        foreach ($vcsUrls as $url) {
            $application->setVcsRepositoryUrl($url);
            $this->assertEquals($url, $application->getVcsRepositoryUrl());
        }
    }

    /**
     * @covers ::getVcsRepositoryUrl
     * @expectedException \RuntimeException
     */
    public function testGetVcsRepositoryUrlWillThrowExceptionIfPropertyNotSet()
    {
        $application = new Application('test');
        $application->getVcsRepositoryUrl();
    }

    /**
     * @covers ::setVcsRepositoryUrl
     * @expectedException \InvalidArgumentException
     */
    public function testSetVcsRepositoryUrlWillThrowExceptionIfNotAString()
    {
        $application = new Application('test');
        $application->setVcsRepositoryUrl([]);
    }

    /**
     * @covers ::setVcsRepositoryUrl
     * @expectedException \InvalidArgumentException
     */
    public function testSetVcsRepositoryUrlWillThrowExceptionIfEmptyString()
    {
        $application = new Application('test');
        $application->setVcsRepositoryUrl('');
    }

    /**
     * @covers ::isInProduction
     * @covers ::setProductionMode
     */
    public function testProductionModePropertyMayBeAccessedViaMethods()
    {
        $application = new Application('test');
        $modes = [
            true,
            false,
        ];
        foreach ($modes as $mode) {
            $application->setProductionMode($mode);
            $this->assertEquals($mode, $application->isInProduction());
        }
    }

    /**
     * @covers ::isInProduction
     * @expectedException \RuntimeException
     */
    public function testIsInProductionWillThrowExceptionIfPropertyNotSet()
    {
        $application = new Application('test');
        $application->isInProduction();
    }

    /**
     * @covers ::setProductionMode
     * @expectedException \InvalidArgumentException
     */
    public function testSetProductionModeWillThrowExceptionIfNotABoolean()
    {
        $application = new Application('test');
        $application->setProductionMode([]);
    }

    /**
     * @covers ::getUnixUsername
     * @covers ::setUnixUsername
     */
    public function testUnixUsernamePropertyMayBeAccessedViaMethods()
    {
        $application = new Application('test');
        $names = [
            'myapp',
            'examplecom',
        ];
        foreach ($names as $name) {
            $application->setUnixUsername($name);
            $this->assertEquals($name, $application->getUnixUsername());
        }
    }

    /**
     * @covers ::getUnixUsername
     * @expectedException \RuntimeException
     */
    public function testGetUnixUsernameWillThrowExceptionIfPropertyNotSet()
    {
        $application = new Application('test');
        $application->getUnixUsername();
    }

    /**
     * @covers ::setUnixUsername
     * @expectedException \InvalidArgumentException
     */
    public function testSetUnixUsernameWillThrowExceptionIfNotAString()
    {
        $application = new Application('test');
        $application->setUnixUsername([]);
    }

    /**
     * @covers ::setUnixUsername
     * @expectedException \InvalidArgumentException
     */
    public function testSetUnixUsernameWillThrowExceptionIfEmptyString()
    {
        $application = new Application('test');
        $application->setUnixUsername('');
    }

    /**
     * @covers ::getTitle
     * @covers ::setTitle
     */
    public function testTitlePropertyMayBeAccessedViaMethods()
    {
        $application = new Application('test');
        $titles = [
            'My Very First Acquia Cloud Application',
            'example.com - D7 Rebuild',
        ];
        foreach ($titles as $title) {
            $application->setTitle($title);
            $this->assertEquals($title, $application->getTitle());
        }
    }

    /**
     * @covers ::getTitle
     * @expectedException \RuntimeException
     */
    public function testGetTitleWillThrowExceptionIfPropertyNotSet()
    {
        $application = new Application('test');
        $application->getTitle();
    }

    /**
     * @covers ::setTitle
     * @expectedException \InvalidArgumentException
     */
    public function testSetTitleWillThrowExceptionIfNotAString()
    {
        $application = new Application('test');
        $application->setTitle([]);
    }

    /**
     * @covers ::setTitle
     * @expectedException \InvalidArgumentException
     */
    public function testSetTitleWillThrowExceptionIfEmptyString()
    {
        $application = new Application('test');
        $application->setTitle('');
    }

    /**
     * @covers ::getUUID
     * @covers ::setUUID
     */
    public function testUUIDPropertyMayBeAccessedViaMethods()
    {
        $application = new Application('test');
        $uuids = [
            '0e88acab-0123-feeb-daed-45bccbd68888',
            '45bcfeeb-acab-0123-8888-daedcbd6d8eb',
        ];
        foreach ($uuids as $uuid) {
            $application->setUUID($uuid);
            $this->assertEquals($uuid, $application->getUUID());
        }
    }

    /**
     * @covers ::getUUID
     * @expectedException \RuntimeException
     */
    public function testGetUUIDWillThrowExceptionIfPropertyNotSet()
    {
        $application = new Application('test');
        $application->getUUID();
    }

    /**
     * @covers ::setUUID
     * @expectedException \InvalidArgumentException
     */
    public function testSetUUIDWillThrowExceptionIfNotAString()
    {
        $application = new Application('test');
        $application->setUUID([]);
    }

    /**
     * @covers ::setUUID
     * @expectedException \RuntimeException
     */
    public function testSetUUIDWillSetNullIfEmptyString()
    {
        $application = new Application('test');
        $application->setUUID('');
        $application->getUUID();
    }

    /**
     * @covers ::getRealm
     * @covers ::setRealm
     */
    public function testRealmPropertyMayBeAccessedViaMethods()
    {
        $application = new Application('test');
        $realms = [
            new Realm('test1'),
            new Realm('test2'),
        ];
        /** @var \Acquia\Platform\Cloud\Hosting\RealmInterface $realm */
        foreach ($realms as $realm) {
            $application->setRealm($realm);
            $this->assertEquals($realm->getName(), $application->getRealm()->getName());
        }
    }

    /**
     * @covers ::getRealm
     * @expectedException \RuntimeException
     */
    public function testGetRealmWillThrowExceptionIfPropertyNotSet()
    {
        $application = new Application('test');
        $application->getRealm();
    }

    /**
     * @covers ::getEnvironmentList
     * @covers ::setEnvironmentList
     */
    public function testEnvironmentListPropertyMayBeAccessedViaMethods()
    {
        $application = new Application('test');
        $environments = new EnvironmentList();
        $environments->append(new Environment('environment1'));
        $environments->append(new Environment('environment2'));
        $application->setEnvironmentList($environments);
        $this->assertEquals($environments, $application->getEnvironmentList());
    }

    /**
     * @covers ::getEnvironmentList
     * @expectedException \RuntimeException
     */
    public function testEnvironmentListWillThrowExceptionIfPropertyNotSet()
    {
        $application = new Application('test');
        $application->getEnvironmentList();
    }
}
