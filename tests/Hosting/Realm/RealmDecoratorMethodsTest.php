<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Realm;

use Acquia\Platform\Cloud\Hosting\Realm\RealmDecoratorMethods;
use Acquia\Platform\Cloud\Hosting\RealmInterface;
use Acquia\Platform\Cloud\Hosting\Realm;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Realm\RealmDecoratorMethods
 */
class RealmDecoratorMethodsTest extends TestCase
{
    const TEST_TRAIT = 'Acquia\Platform\Cloud\Hosting\Realm\RealmDecoratorMethods';
    const TEST_APP = 'Acquia\Platform\Cloud\Hosting\RealmInterface';

    /**
     * @covers ::getRealm
     * @covers ::setRealm
     */
    public function testRealmDecoratorMethodsMaySetDecoratedRealm()
    {
        /** @var RealmDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        /** @var RealmInterface $mockRealm   */
        $mockRealm = $this->getMockBuilder(self::TEST_APP)->getMock();

        $mockTrait->setRealm($mockRealm);
        $this->assertEquals($mockRealm, $mockTrait->getRealm());
    }

    /**
     * @covers ::getName
     * @covers ::__toString
     * @covers ::getHostNameRoot
     * @covers ::getDefaultSiteDomainNameRoot
     * @covers ::isDefault
     * @dataProvider getRealmInterfaceGetters
     */
    public function testRealmDecoratorMethodsPassesGettersToRealm($getter, $expected)
    {
        /** @var RealmDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockRealm = $this->getMockBuilder(self::TEST_APP)
            ->getMock();
        $mockRealm->expects($this->once())
            ->method($getter)
            ->willReturn($expected);

        $mockTrait->setRealm($mockRealm);
        $this->assertEquals($expected, call_user_func([$mockTrait, $getter]));
    }

    /**
     * @covers ::setDefault
     * @dataProvider getRealmInterfaceSetters
     */
    public function testRealmDecoratorMethodsPassesSettersToRealm($setter, $expected)
    {
        /** @var RealmDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockRealm = $this->getMockBuilder(self::TEST_APP)
            ->getMock();
        $mockRealm->expects($this->once())
            ->method($setter)
            ->with($expected);

        $mockTrait->setRealm($mockRealm);
        call_user_func([$mockTrait, $setter], $expected);
    }

    public function getRealmInterfaceGetters()
    {
        return [
            ['getName', 'realm1'],
            ['__toString', 'realm1'],
            ['getHostNameRoot', 'test.realm1.acquia.com'],
            ['getDefaultSiteDomainNameRoot', 'realm1.acquia-sites.com'],
            ['isDefault', true],
        ];
    }

    public function getRealmInterfaceSetters()
    {
        return [
            ['setDefault', true],
        ];
    }
}
