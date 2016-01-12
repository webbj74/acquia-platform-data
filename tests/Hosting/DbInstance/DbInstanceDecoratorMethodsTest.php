<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\DbInstance;

use Acquia\Platform\Cloud\Hosting\DbInstance\DbInstanceDecoratorMethods;
use Acquia\Platform\Cloud\Hosting\DbInstanceInterface;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\DbInstance\DbInstanceDecoratorMethods
 */
class DbInstanceDecoratorMethodsTest extends \PHPUnit_Framework_TestCase
{
    const TEST_TRAIT = 'Acquia\Platform\Cloud\Hosting\DbInstance\DbInstanceDecoratorMethods';
    const TEST_APP = 'Acquia\Platform\Cloud\Hosting\DbInstanceInterface';

    /**
     * @covers ::getDbInstance
     * @covers ::setDbInstance
     */
    public function testDbInstanceDecoratorMethodsMaySetDecoratedDbInstance()
    {
        /** @var DbInstanceDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        /** @var DbInstanceInterface $mockApp   */
        $mockApp = $this->getMockBuilder(self::TEST_APP)->getMock();

        $mockTrait->setDbInstance($mockApp);
        $this->assertEquals($mockApp, $mockTrait->getDbInstance());
    }

    /**
     * @covers ::getInstanceName
     * @covers ::getName
     * @covers ::getUsername
     * @covers ::getPassword
     * @covers ::getHost
     * @covers ::getClusterID
     * @dataProvider getDbInstanceInterfaceGetters
     */
    public function testDbInstanceDecoratorMethodsPassesGettersToDbInstance($getter, $expected)
    {
        /** @var DbInstanceDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockApp = $this->getMockBuilder(self::TEST_APP)
            ->getMock();
        $mockApp->expects($this->once())
            ->method($getter)
            ->willReturn($expected);

        $mockTrait->setDbInstance($mockApp);
        $this->assertEquals($expected, call_user_func([$mockTrait, $getter]));
    }

    /**
     * @covers ::setName
     * @covers ::setUsername
     * @covers ::setPassword
     * @covers ::setHost
     * @covers ::setClusterID
     * @dataProvider getDbInstanceInterfaceSetters
     */
    public function testDbInstanceDecoratorMethodsPassesSettersToDbInstance($setter, $expected)
    {
        /** @var DbInstanceDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockApp = $this->getMockBuilder(self::TEST_APP)
            ->getMock();
        $mockApp->expects($this->once())
            ->method($setter)
            ->with($expected);

        $mockTrait->setDbInstance($mockApp);
        call_user_func([$mockTrait, $setter], $expected);
    }

    public function getDbInstanceInterfaceGetters()
    {
        return [
            ['getInstanceName', 'db123'],
            ['getName', 'dev'],
            ['getUsername', 'user'],
            ['getPassword', 'hunter2'],
            ['getHost', 'staging-123'],
            ['getClusterID', 1234],
        ];
    }

    public function getDbInstanceInterfaceSetters()
    {
        return [
            ['setName', 'dev'],
            ['setUsername', 'user'],
            ['setPassword', 'hunter2'],
            ['setHost', 'staging-123'],
            ['setClusterID', 1234],
        ];
    }
}
