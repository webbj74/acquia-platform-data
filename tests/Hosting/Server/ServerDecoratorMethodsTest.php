<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Server;

use Acquia\Platform\Cloud\Hosting\Server\ServerDecoratorMethods;
use Acquia\Platform\Cloud\Hosting\ServerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Server\ServerDecoratorMethods
 */
class ServerDecoratorMethodsTest extends TestCase
{
    const TEST_TRAIT = 'Acquia\Platform\Cloud\Hosting\Server\ServerDecoratorMethods';
    const TEST_CLASS = 'Acquia\Platform\Cloud\Hosting\ServerInterface';

    /**
     * @covers ::getServer
     * @covers ::setServer
     */
    public function testServerDecoratorMethodsMaySetDecoratedServer()
    {
        /** @var ServerDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        /** @var ServerInterface $mockClass   */
        $mockClass = $this->getMockBuilder(self::TEST_CLASS)->getMock();

        $mockTrait->setServer($mockClass);
        $this->assertEquals($mockClass, $mockTrait->getServer());
    }

    /**
     * @covers ::getName
     * @covers ::getFullyQualifiedDomainName
     * @covers ::getAmiType
     * @covers ::getEc2Region
     * @covers ::getEc2AvailabilityZone
     * @covers ::getServices
     * @dataProvider getServerInterfaceGetters
     */
    public function testServerDecoratorMethodsPassesGettersToServer($getter, $expected)
    {
        /** @var ServerDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockClass = $this->getMockBuilder(self::TEST_CLASS)
            ->getMock();
        $mockClass->expects($this->once())
            ->method($getter)
            ->willReturn($expected);

        $mockTrait->setServer($mockClass);
        $this->assertEquals($expected, call_user_func([$mockTrait, $getter]));
    }

    /**
     * @covers ::setFullyQualifiedDomainName
     * @covers ::setAmiType
     * @covers ::setEc2Region
     * @covers ::setEc2AvailabilityZone
     * @covers ::setServices
     * @dataProvider getServerInterfaceSetters
     */
    public function testServerDecoratorMethodsPassesSettersToServer($setter, $expected)
    {
        /** @var ServerDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockClass = $this->getMockBuilder(self::TEST_CLASS)
            ->getMock();
        $mockClass->expects($this->once())
            ->method($setter)
            ->with($expected);

        $mockTrait->setServer($mockClass);
        call_user_func([$mockTrait, $setter], $expected);
    }

    public function getServerInterfaceGetters()
    {
        return [
            ['getName', 'web-123'],
            ['getFullyQualifiedDomainName', 'web-123.prod.hosting.acquia.com'],
            ['getAmiType', 'm2.xlarge'],
            ['getEc2Region', 'us-east-1'],
            ['getEc2AvailabilityZone', 'us-east-1d'],
            ['getServices', array('web' => array('status' => 'online'))],
        ];
    }

    public function getServerInterfaceSetters()
    {
        return [
            ['setFullyQualifiedDomainName', 'web-123.prod.hosting.acquia.com'],
            ['setAmiType', 'm2.xlarge'],
            ['setEc2Region', 'us-east-1'],
            ['setEc2AvailabilityZone', 'us-east-1d'],
            ['setServices', array('web' => array('status' => 'online'))],
        ];
    }
}
