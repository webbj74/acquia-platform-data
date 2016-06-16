<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Environment;

use Acquia\Platform\Cloud\Hosting\Environment\EnvironmentDecoratorMethods;
use Acquia\Platform\Cloud\Hosting\EnvironmentInterface;
use Acquia\Platform\Cloud\Hosting\Realm;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Environment\EnvironmentDecoratorMethods
 */
class EnvironmentDecoratorMethodsTest extends \PHPUnit_Framework_TestCase
{
    const TEST_TRAIT = 'Acquia\Platform\Cloud\Hosting\Environment\EnvironmentDecoratorMethods';
    const TEST_APP = 'Acquia\Platform\Cloud\Hosting\EnvironmentInterface';

    /**
     * @covers ::getEnvironment
     * @covers ::setEnvironment
     */
    public function testEnvironmentDecoratorMethodsMaySetDecoratedEnvironment()
    {
        /** @var EnvironmentDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        /** @var EnvironmentInterface $mockEnvironment   */
        $mockEnvironment = $this->getMockBuilder(self::TEST_APP)->getMock();

        $mockTrait->setEnvironment($mockEnvironment);
        $this->assertEquals($mockEnvironment, $mockTrait->getEnvironment());
    }

    /**
     * @covers ::getName
     * @covers ::getRevision
     * @covers ::getDefaultHostName
     * @covers ::getDatabaseClusterList
     * @covers ::getDefaultDomainName
     * @covers ::isInLiveDev
     * @covers ::getUnixUserName
     * @covers ::getMachineName
     * @dataProvider getEnvironmentInterfaceGetters
     */
    public function testEnvironmentDecoratorMethodsPassesGettersToEnvironment($getter, $expected)
    {
        /** @var EnvironmentDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockEnvironment = $this->getMockBuilder(self::TEST_APP)
            ->getMock();
        $mockEnvironment->expects($this->once())
            ->method($getter)
            ->willReturn($expected);

        $mockTrait->setEnvironment($mockEnvironment);
        $this->assertEquals($expected, call_user_func([$mockTrait, $getter]));
    }

    /**
     * @covers ::setRevision
     * @covers ::setDefaultHostName
     * @covers ::setDatabaseClusterList
     * @covers ::setDefaultDomainName
     * @covers ::setInLiveDev
     * @covers ::setUnixUserName
     * @covers ::setMachineName
     * @dataProvider getEnvironmentInterfaceSetters
     */
    public function testEnvironmentDecoratorMethodsPassesSettersToEnvironment($setter, $expected)
    {
        /** @var EnvironmentDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockEnvironment = $this->getMockBuilder(self::TEST_APP)
            ->getMock();
        $mockEnvironment->expects($this->once())
            ->method($setter)
            ->with($expected);

        $mockTrait->setEnvironment($mockEnvironment);
        call_user_func([$mockTrait, $setter], $expected);
    }

    public function getEnvironmentInterfaceGetters()
    {
        return [
            ['getApplicationQualifiedName', 'test1.test'],
            ['getName', 'test1'],
            ['getRevision', 'tags/301'],
            ['getDefaultHostName', 'test1-123.test.hosting.acquia.com'],
            ['getDatabaseClusterList', [1,2]],
            ['getDefaultDomainName', 'test1stg.acquia-sites.com'],
            ['isInLiveDev', true],
            ['getUnixUserName', 'test1.test'],
            ['getMachineName', 'test1stg'],
        ];
    }

    public function getEnvironmentInterfaceSetters()
    {
        return [
            ['setRevision', 'tags/302'],
            ['setDefaultHostName', 'test-456.test.hosting.acquia.com'],
            ['setDatabaseClusterList', [4,5]],
            ['setDefaultDomainName', 'test2stg.acquia-sites.com'],
            ['setInLiveDev', true],
            ['setUnixUserName', 'test2.test'],
            ['setMachineName', 'test2stg'],
        ];
    }
}
