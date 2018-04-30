<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Application;

use Acquia\Platform\Cloud\Hosting\Application\ApplicationDecoratorMethods;
use Acquia\Platform\Cloud\Hosting\ApplicationInterface;
use Acquia\Platform\Cloud\Hosting\Environment;
use Acquia\Platform\Cloud\Hosting\Environment\EnvironmentList;
use Acquia\Platform\Cloud\Hosting\Realm;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Application\ApplicationDecoratorMethods
 */
class ApplicationDecoratorMethodsTest extends TestCase
{
    const TEST_TRAIT = 'Acquia\Platform\Cloud\Hosting\Application\ApplicationDecoratorMethods';
    const TEST_APP = 'Acquia\Platform\Cloud\Hosting\ApplicationInterface';

    /**
     * @covers ::getApplication
     * @covers ::setApplication
     */
    public function testApplicationDecoratorMethodsMaySetDecoratedApplication()
    {
        /** @var ApplicationDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        /** @var ApplicationInterface $mockApp   */
        $mockApp = $this->getMockBuilder(self::TEST_APP)->getMock();

        $mockTrait->setApplication($mockApp);
        $this->assertEquals($mockApp, $mockTrait->getApplication());
    }

    /**
     * @covers ::getName
     * @covers ::getRealmQualifiedName
     * @covers ::getVcsType
     * @covers ::getVcsRepositoryUrl
     * @covers ::isInProduction
     * @covers ::getUnixUsername
     * @covers ::getTitle
     * @covers ::getUUID
     * @covers ::getRealm
     * @covers ::getEnvironmentList
     * @dataProvider getApplicationInterfaceGetters
     */
    public function testApplicationDecoratorMethodsPassesGettersToApplication($getter, $expected)
    {
        /** @var ApplicationDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockApp = $this->getMockBuilder(self::TEST_APP)
            ->getMock();
        $mockApp->expects($this->once())
            ->method($getter)
            ->willReturn($expected);

        $mockTrait->setApplication($mockApp);
        $this->assertEquals($expected, call_user_func([$mockTrait, $getter]));
    }

    /**
     * @covers ::setVcsType
     * @covers ::setVcsRepositoryUrl
     * @covers ::setProductionMode
     * @covers ::setUnixUsername
     * @covers ::setTitle
     * @covers ::setUUID
     * @covers ::setRealm
     * @covers ::setEnvironmentList
     * @dataProvider getApplicationInterfaceSetters
     */
    public function testApplicationDecoratorMethodsPassesSettersToApplication($setter, $expected)
    {
        /** @var ApplicationDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockApp = $this->getMockBuilder(self::TEST_APP)
            ->getMock();
        $mockApp->expects($this->once())
            ->method($setter)
            ->with($expected);

        $mockTrait->setApplication($mockApp);
        call_user_func([$mockTrait, $setter], $expected);
    }

    public function getApplicationInterfaceGetters()
    {
        return [
            ['getName', 'test'],
            ['getRealmQualifiedName', 'test:test'],
            ['getVcsType', 'git'],
            ['getVcsRepositoryUrl', 'git@github.com:webbj74/acquia-platform-cloud-data-model.git'],
            ['isInProduction', true],
            ['getUnixUsername', 'test'],
            ['getTitle', 'The Test'],
            ['getUUID', 'cdb73d94-374d-401f-b419-3781fa96fb05'],
            ['getRealm', ['realm']],
            ['getEnvironmentList', ['environments']],
        ];
    }

    public function getApplicationInterfaceSetters()
    {
        return [
            ['setVcsType', 'git'],
            ['setVcsRepositoryUrl', 'git@github.com:webbj74/acquia-platform-cloud-data-model.git'],
            ['setProductionMode', true],
            ['setUnixUsername', 'test'],
            ['setTitle', 'The Test'],
            ['setUUID', 'cdb73d94-374d-401f-b419-3781fa96fb05'],
            ['setRealm', new Realm('realm1')],
            ['setEnvironmentList', new EnvironmentList([new Environment('environment1')])],
        ];
    }
}
