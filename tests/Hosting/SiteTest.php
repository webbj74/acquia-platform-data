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

use Acquia\Platform\Cloud\Hosting\Site;
use Acquia\Platform\Cloud\Hosting\Realm;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Site
 */
class SiteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getRealmQualifiedName
     */
    public function testNamePropertyMayBeAccessedViaMethods()
    {
        $site = new Site('test');
        $this->assertEquals('test', $site->getName());
        $site->setRealm(new Realm('foo'));
        $this->assertEquals('foo:test', $site->getRealmQualifiedName());
    }

    /**
     * @covers ::getVcsType
     * @covers ::setVcsType
     */
    public function testVcsTypePropertyMayBeAccessedViaMethods()
    {
        $site = new Site('test');
        foreach (['git', 'svn'] as $vcs) {
            $site->setVcsType($vcs);
            $this->assertEquals($vcs, $site->getVcsType());
        }
    }

    /**
     * @covers ::getVcsType
     * @expectedException \RuntimeException
     */
    public function testGetVcsTypeWillThrowExceptionIfPropertyNotSet()
    {
        $site = new Site('test');
        $site->getVcsType();
    }

    /**
     * @covers ::getVcsRepositoryUrl
     * @covers ::setVcsRepositoryUrl
     */
    public function testVcsRepositoryUrlPropertyMayBeAccessedViaMethods()
    {
        $site = new Site('test');
        $vcsUrls = [
            'https://vcs-123.prod.hosting.acquia.com/mysite',
            'examplecom@vcs-456.devcloud.hosting.acquia.com:examplecom.git',
        ];
        foreach ($vcsUrls as $url) {
            $site->setVcsRepositoryUrl($url);
            $this->assertEquals($url, $site->getVcsRepositoryUrl());
        }
    }

    /**
     * @covers ::getVcsRepositoryUrl
     * @expectedException \RuntimeException
     */
    public function testGetVcsRepositoryUrlWillThrowExceptionIfPropertyNotSet()
    {
        $site = new Site('test');
        $site->getVcsRepositoryUrl();
    }

    /**
     * @covers ::isInProduction
     * @covers ::setProductionMode
     */
    public function testProductionModePropertyMayBeAccessedViaMethods()
    {
        $site = new Site('test');
        $modes = [
            true,
            false,
        ];
        foreach ($modes as $mode) {
            $site->setProductionMode($mode);
            $this->assertEquals($mode, $site->isInProduction());
        }
    }

    /**
     * @covers ::isInProduction
     * @expectedException \RuntimeException
     */
    public function testIsInProductionWillThrowExceptionIfPropertyNotSet()
    {
        $site = new Site('test');
        $site->isInProduction();
    }

    /**
     * @covers ::getUnixUsername
     * @covers ::setUnixUsername
     */
    public function testUnixUsernamePropertyMayBeAccessedViaMethods()
    {
        $site = new Site('test');
        $names = [
            'mysite',
            'examplecom',
        ];
        foreach ($names as $name) {
            $site->setUnixUsername($name);
            $this->assertEquals($name, $site->getUnixUsername());
        }
    }

    /**
     * @covers ::getUnixUsername
     * @expectedException \RuntimeException
     */
    public function testGetUnixUsernameWillThrowExceptionIfPropertyNotSet()
    {
        $site = new Site('test');
        $site->getUnixUsername();
    }

    /**
     * @covers ::getTitle
     * @covers ::setTitle
     */
    public function testTitlePropertyMayBeAccessedViaMethods()
    {
        $site = new Site('test');
        $titles = [
            'My Very First Acquia Cloud Site',
            'example.com - D7 Rebuild',
        ];
        foreach ($titles as $title) {
            $site->setTitle($title);
            $this->assertEquals($title, $site->getTitle());
        }
    }

    /**
     * @covers ::getTitle
     * @expectedException \RuntimeException
     */
    public function testGetTitleWillThrowExceptionIfPropertyNotSet()
    {
        $site = new Site('test');
        $site->getTitle();
    }

    /**
     * @covers ::getUUID
     * @covers ::setUUID
     */
    public function testUUIDPropertyMayBeAccessedViaMethods()
    {
        $site = new Site('test');
        $uuids = [
            '0e88acab-0123-feeb-daed-45bccbd68888',
            '45bcfeeb-acab-0123-8888-daedcbd6d8eb',
        ];
        foreach ($uuids as $uuid) {
            $site->setUUID($uuid);
            $this->assertEquals($uuid, $site->getUUID());
        }
    }

    /**
     * @covers ::getUUID
     * @expectedException \RuntimeException
     */
    public function testGetUUIDWillThrowExceptionIfPropertyNotSet()
    {
        $site = new Site('test');
        $site->getUUID();
    }

    /**
     * @covers ::getRealm
     * @covers ::setRealm
     */
    public function testRealmPropertyMayBeAccessedViaMethods()
    {
        $site = new Site('test');
        $realms = [
            new Realm('test1'),
            new Realm('test2'),
        ];
        /** @var \Acquia\Platform\Cloud\Hosting\RealmInterface $realm */
        foreach ($realms as $realm) {
            $site->setRealm($realm);
            $this->assertEquals($realm->getName(), $site->getRealm()->getName());
        }
    }

    /**
     * @covers ::getRealm
     * @expectedException \RuntimeException
     */
    public function testGetRealmWillThrowExceptionIfPropertyNotSet()
    {
        $site = new Site('test');
        $site->getRealm();
    }
}
