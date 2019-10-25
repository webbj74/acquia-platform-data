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

use Acquia\Platform\Cloud\Hosting\Server;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Server
 */
class ServerTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getName
     */
    public function testNamePropertyMayBeAccessedViaMethods()
    {
        $server = new Server('test');
        $this->assertEquals('test', $server->getName());
    }

    /**
     * @covers ::__construct
     */
    public function testNamePropertyMustBeAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server([]);
    }

    /**
     * @covers ::__construct
     */
    public function testNamePropertyMustBeAnAlphanumericString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server(' ');
    }

    /**
     * @covers ::create()
     */
    public function testServerCanBeInstantiatedWithFactoryMethod()
    {
        $server = Server::create(['name' => 'web-123']);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Server', $server);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\ServerInterface', $server);

        $server = Server::create(
            [
                'name' => 'web-123',
                'fully_qualified_domain_name' => 'web-123.prod.hosting.acquia.com',
                'ami_type' => 'm2.xlarge',
                'ec2_region' => 'us-east-1',
                'ec2_availability_zone' => 'us-east-1d',
                'services' => array('web' => array('status' => 'online'))
            ]
        );
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Server', $server);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\ServerInterface', $server);
    }

    /**
     * @covers ::getFullyQualifiedDomainName
     * @covers ::setFullyQualifiedDomainName
     */
    public function testFullyQualifiedDomainNamePropertyMayBeAccessedViaMethods()
    {
        $fqdn = 'web-123.prod.hosting.acquia.com';
        $server = new Server('test');
        $server->setFullyQualifiedDomainName($fqdn);
        $this->assertEquals($fqdn, $server->getFullyQualifiedDomainName());
    }

    /**
     * @covers ::getFullyQualifiedDomainName
     */
    public function testGetFullyQualifiedDomainNameWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $server = new Server('test');
        $server->getFullyQualifiedDomainName();
    }

    /**
     * @covers ::setFullyQualifiedDomainName
     */
    public function testSetFullyQualifiedDomainNameWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server('test');
        $server->setFullyQualifiedDomainName([]);
    }

    /**
     * @covers ::setFullyQualifiedDomainName
     */
    public function testSetFullyQualifiedDomainNameWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server('test');
        $server->setFullyQualifiedDomainName('');
    }

    /**
     * @covers ::getAmiType
     * @covers ::setAmiType
     */
    public function testAmiTypePropertyMayBeAccessedViaMethods()
    {
        $ami = 'm2.xlarge';
        $server = new Server('test');
        $server->setAmiType($ami);
        $this->assertEquals($ami, $server->getAmiType());
    }

    /**
     * @covers ::getAmiType
     */
    public function testGetAmiTypeWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $server = new Server('test');
        $server->getAmiType();
    }

    /**
     * @covers ::setAmiType
     */
    public function testSetAmiTypeWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server('test');
        $server->setAmiType([]);
    }

    /**
     * @covers ::setAmiType
     */
    public function testSetAmiTypeWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server('test');
        $server->setAmiType('');
    }

    /**
     * @covers ::getEc2Region
     * @covers ::setEc2Region
     */
    public function testEc2RegionPropertyMayBeAccessedViaMethods()
    {
        $ec2region = 'us-east-1';
        $server = new Server('test');
        $server->setEc2Region($ec2region);
        $this->assertEquals($ec2region, $server->getEc2Region());
    }

    /**
     * @covers ::getEc2Region
     */
    public function testGetEc2RegionWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $server = new Server('test');
        $server->getEc2Region();
    }

    /**
     * @covers ::setEc2Region
     */
    public function testSetEc2RegionWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server('test');
        $server->setEc2Region([]);
    }

    /**
     * @covers ::setEc2Region
     */
    public function testSetEc2RegionWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server('test');
        $server->setEc2Region('');
    }

    /**
     * @covers ::getEc2AvailabilityZone
     * @covers ::setEc2AvailabilityZone
     */
    public function testEc2AvailabilityZonePropertyMayBeAccessedViaMethods()
    {
        $ec2AvailabilityZone = 'us-east-1d';
        $server = new Server('test');
        $server->setEc2AvailabilityZone($ec2AvailabilityZone);
        $this->assertEquals($ec2AvailabilityZone, $server->getEc2AvailabilityZone());
    }

    /**
     * @covers ::getEc2AvailabilityZone
     */
    public function testGetEc2AvailabilityZoneWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $server = new Server('test');
        $server->getEc2AvailabilityZone();
    }

    /**
     * @covers ::setEc2AvailabilityZone
     */
    public function testSetEc2AvailabilityZoneWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server('test');
        $server->setEc2AvailabilityZone([]);
    }

    /**
     * @covers ::setEc2AvailabilityZone
     */
    public function testSetEc2AvailabilityZoneWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server('test');
        $server->setEc2AvailabilityZone('');
    }

    /**
     * @covers ::getServices
     * @covers ::setServices
     */
    public function testServicesPropertyMayBeAccessedViaMethods()
    {
        $services = array('web' => array('status' => 'online'));
        $server = new Server('test');
        $server->setServices($services);
        $this->assertEquals($services, $server->getServices());
    }

    /**
     * @covers ::getServices
     */
    public function testGetServicesWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $server = new Server('test');
        $server->getServices();
    }

    /**
     * @covers ::setServices
     */
    public function testSetServicesWillThrowExceptionIfNotAnArray()
    {
        $this->expectException(InvalidArgumentException::class);
        $server = new Server('test');
        $server->setServices('');
    }

    /**
     * @covers ::setServices
     */
    public function testSetServicesWillNotThrowExceptionIfEmptyArray()
    {
        $server = new Server('test');
        $server->setServices([]);
        $this->assertEmpty($server->getServices());
    }

    /**
     * @covers ::isBalancerServer
     */
    public function testIsBalancerServer()
    {
        $server = new Server('test');
        $server->setServices([]);
        $this->assertFalse($server->isBalancerServer());

        $server->setServices(['varnish' =>[]]);
        $this->assertTrue($server->isBalancerServer());
    }

    /**
     * @covers ::isDatabaseServer
     */
    public function testIsDatabaseServer()
    {
        $server = new Server('test');
        $server->setServices([]);
        $this->assertFalse($server->isDatabaseServer());

        $server->setServices(['database' =>[]]);
        $this->assertTrue($server->isDatabaseServer());
    }

    /**
     * @covers ::isFileServer
     */
    public function testIsFileServer()
    {
        $server = new Server('test');
        $this->assertFalse($server->isFileServer());

        $server = new Server('fs-123');
        $this->assertTrue($server->isFileServer());
    }

    /**
     * @covers ::isVcsServer
     */
    public function testIsVcsServer()
    {
        $server = new Server('test');
        $server->setServices([]);
        $this->assertFalse($server->isVcsServer());

        $server->setServices(['vcs' =>[]]);
        $this->assertTrue($server->isVcsServer());
    }

    /**
     * @covers ::isWebServer
     */
    public function testIsWebServer()
    {
        $server = new Server('test');
        $server->setServices([]);
        $this->assertFalse($server->isWebServer());

        $server->setServices(['web' =>[]]);
        $this->assertTrue($server->isWebServer());
    }
}
