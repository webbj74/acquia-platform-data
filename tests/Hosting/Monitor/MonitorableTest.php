<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Monitor;

use Acquia\Platform\Cloud\Hosting\Monitor\MonitorList;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Monitor\Monitorable
 */
class MonitorableTest extends \PHPUnit_Framework_TestCase
{
    protected function getMonitorable()
    {
        return $this->getMockForTrait('Acquia\Platform\Cloud\Hosting\Monitor\Monitorable');
    }

    protected function getMonitor($serviceName = 'service')
    {
        $mock = $this->getMock('Acquia\Platform\Cloud\Hosting\Monitor\MonitorInterface');
        $mock->expects($this->any())
            ->method('getMonitoringUrls')
            ->willReturn(['url'])
        ;
        $mock->expects($this->any())
            ->method('getName')
            ->willReturn($serviceName)
        ;
        return $mock;
    }

    protected function getMonitorList()
    {
        return new MonitorList();
    }

    /**
     * @covers ::addMonitor
     * @expectedException \RuntimeException
     */
    public function testThrowsExceptionIfMonitorAppendedBeforeInitialization()
    {
        
        $monitorable = $this->getMonitorable();
        $monitorable->addMonitor($this->getMonitor());
    }

    /**
     * @covers ::getMonitoringUrls
     * @expectedException \RuntimeException
     */
    public function testThrowsExceptionIfUrlsRequestedBeforeInitialization()
    {
        
        $monitorable = $this->getMonitorable();
        $monitorable->getMonitoringUrls();
    }

    /**
     * @covers ::initializeMonitorList
     */
    public function testCanBeInitializedWithAMonitorList()
    {
        $monitorable = $this->getMonitorable();
        $monitorable->initializeMonitorList($this->getMonitorList());
        $this->assertEquals([], $monitorable->getMonitoringUrls());
    }

    /**
     * @covers ::initializeMonitorList
     */
    public function testCanBeInitializedWithoutAMonitorList()
    {
        $monitorable = $this->getMonitorable();
        $monitorable->initializeMonitorList();
        $this->assertEquals([], $monitorable->getMonitoringUrls());
    }

    /**
     * @covers ::initializeMonitorList
     * @covers ::addMonitor
     * @covers ::getMonitoringUrls
     */
    public function testCanReturnUrlsFromMonitorList()
    {
        $monitorable = $this->getMonitorable();
        $monitorable->initializeMonitorList($this->getMonitorList());
        $monitorable->addMonitor($this->getMonitor('service1'));
        $monitorable->addMonitor($this->getMonitor('service2'));
        $this->assertEquals(
            ['service1' => ['url'], 'service2' => ['url']],
            $monitorable->getMonitoringUrls()
        );
        $this->assertEquals(
            ['service2' => ['url']],
            $monitorable->getMonitoringUrls('service2')
        );
    }
}
