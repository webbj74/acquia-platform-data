<?php

/**
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\DnsRecord;

use Acquia\Platform\Cloud\Hosting\DnsRecord;
use Acquia\Platform\Cloud\Hosting\DnsRecord\DnsRecordList;
use PHPUnit\Framework\TestCase;

/**
 * Class DnsRecordListTest.
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\DnsRecord\DnsRecordList
 */
class DnsRecordListTest extends TestCase
{
    /**
     * A DnsRecordList populated with test records.
     *
     * @var \Acquia\Platform\Cloud\Hosting\DnsRecord\DnsRecordListInterface
     */
    protected $dnsRecordList;

    /**
     * Set up test fixtures.
     */
    protected function setUp()
    {
        $this->dnsRecordList = new DnsRecordList();
        $this->dnsRecordList->append(new DnsRecord('A', '1.1.1.1'));
        $this->dnsRecordList->append(new DnsRecord('AAAA', '2600:1800:5::10'));
        $this->dnsRecordList->append(new DnsRecord('CNAME', 'foo.realm.acquia-sites.com'));
        $this->dnsRecordList->append(new DnsRecord('CNAME', 'bar.example.com'));
    }

    /**
     * DnsRecordList validates the type when appending new DnsRecord objects.
     */
    public function testThatListRequiresValidDnsRecord()
    {
        $this->expectException('InvalidArgumentException');
        $dnsRecordList = new DnsRecordList();
        $dnsRecordList->append([]);
    }

    /**
     * Test that DnsRecordList can return a filtered list of A records.
     */
    public function testGetARecords()
    {
        $filteredDnsRecords = $this->dnsRecordList->getARecords();
        $this->assertCount(1, $filteredDnsRecords);
        $this->assertEquals('1.1.1.1', $filteredDnsRecords->offsetGet(0)->getValue());
    }

    /**
     * Test that DnsRecordList can return a filtered list of AAAA records.
     */
    public function testGetAaaaRecords()
    {
        $filteredDnsRecords = $this->dnsRecordList->getAaaaRecords();
        $this->assertCount(1, $filteredDnsRecords);
        $this->assertEquals('2600:1800:5::10', $filteredDnsRecords->offsetGet(0)->getValue());
    }

    /**
     * Test that DnsRecordList can return a filtered list of CNAME records.
     */
    public function testGetCnameRecords()
    {
        $filteredDnsRecords = $this->dnsRecordList->getCnameRecords();
        $this->assertCount(2, $filteredDnsRecords);
        $this->assertEquals('foo.realm.acquia-sites.com', $filteredDnsRecords->offsetGet(0)->getValue());
        $this->assertEquals('bar.example.com', $filteredDnsRecords->offsetGet(1)->getValue());
    }
}
