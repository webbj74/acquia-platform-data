<?php

/**
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\DnsConfig;

use Acquia\Platform\Cloud\Hosting\DnsConfig;
use Acquia\Platform\Cloud\Hosting\DnsConfig\DnsConfigList;
use PHPUnit\Framework\TestCase;

/**
 * Class DnsConfigListTest.
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\DnsConfig\DnsConfigList
 */
class DnsConfigListTest extends TestCase
{
    /**
     * A DnsConfigList populated with test records.
     *
     * @var \Acquia\Platform\Cloud\Hosting\DnsConfig\DnsConfigListInterface
     */
    protected $dnsConfigList;

    /**
     * Set up test fixtures.
     */
    protected function setUp(): void
    {
        $this->dnsConfigList = new DnsConfigList();
        $this->dnsConfigList->append(new DnsConfig('A', '1.1.1.1'));
        $this->dnsConfigList->append(new DnsConfig('AAAA', '2600:1800:5::10'));
        $this->dnsConfigList->append(new DnsConfig('CNAME', 'foo.realm.acquia-sites.com'));
        $this->dnsConfigList->append(new DnsConfig('CNAME', 'bar.example.com'));
        parent::setUp();
    }

    /**
     * DnsConfigList validates the type when appending new DnsConfig objects.
     */
    public function testThatListRequiresValidDnsConfig()
    {
        $this->expectException('InvalidArgumentException');
        $dnsConfigList = new DnsConfigList();
        $dnsConfigList->append([]);
    }

    /**
     * Test that DnsConfigList can return a filtered list of A records.
     */
    public function testGetARecords()
    {
        $filteredDnsConfigs = $this->dnsConfigList->getARecords();
        $this->assertCount(1, $filteredDnsConfigs);
        $this->assertEquals('1.1.1.1', $filteredDnsConfigs->offsetGet(0)->getValue());
    }

    /**
     * Test that DnsConfigList can return a filtered list of AAAA records.
     */
    public function testGetAaaaRecords()
    {
        $filteredDnsConfigs = $this->dnsConfigList->getAaaaRecords();
        $this->assertCount(1, $filteredDnsConfigs);
        $this->assertEquals('2600:1800:5::10', $filteredDnsConfigs->offsetGet(0)->getValue());
    }

    /**
     * Test that DnsConfigList can return a filtered list of CNAME records.
     */
    public function testGetCnameRecords()
    {
        $filteredDnsConfigs = $this->dnsConfigList->getCnameRecords();
        $this->assertCount(2, $filteredDnsConfigs);
        $this->assertEquals('foo.realm.acquia-sites.com', $filteredDnsConfigs->offsetGet(0)->getValue());
        $this->assertEquals('bar.example.com', $filteredDnsConfigs->offsetGet(1)->getValue());
    }
}
