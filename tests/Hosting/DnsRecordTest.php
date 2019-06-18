<?php

/**
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting;

use Acquia\Platform\Cloud\Hosting\DnsRecord;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\DnsRecord
 */
class DnsRecordTest extends TestCase
{
    /**
     * Data provider of valid DNS records.
     *
     * @return array[]
     *   An array of test fixtures.
     */
    public function validDnsRecordDataProvider()
    {
        return [
            ['A', '1.1.1.1'],
            ['A', '123.45.67.89'],
            ['AAAA', '2600:1800:5::10'],
            ['CNAME', 'foo.realm.acquia-sites.com'],
            ['CNAME', 'bar.example.com'],
        ];
    }

    /**
     * Test that valid types and values can be used to construct a DnsRecord object.
     *
     * @dataProvider validDnsRecordDataProvider
     *
     * @param string $type
     *   The type of DNS record (A, AAAA, CNAME).
     * @param string $value
     *   The value of the DNS record (IPv4 address, IPv6 address, CNAME).
     */
    public function testInstanceNamePropertyMayBeAccessedViaMethods(string $type, string $value)
    {
        $dnsRecord = new DnsRecord($type, $value);
        $this->assertInstanceOf(DnsRecord::class, $dnsRecord);
        $this->assertEquals($type, $dnsRecord->getType());
        $this->assertEquals($value, $dnsRecord->getValue());
    }

    /**
     * Data provider of invalid DNS records.
     *
     * @return array[]
     *   An array of test fixtures.
     */
    public function invalidDnsRecordDataProvider()
    {
        return [
            ['', ''],
            ['foo', 'bar'],
            ['a', '12.34.56.78'],
            ['A', 'baz'],
            ['A', 'qux.example.com'],
            ['aaaa', '2600:1800:5::10'],
            ['AAAA', 'foo'],
            ['AAAA', '12.34.56.78'],
            ['AAAA', 'bar.example.com'],
            ['cname', 'baz'],
            ['CNAME', ''],
            ['CNAME', '2600:1800:5::10'],
        ];
    }

    /**
     * Test that invalid types and values result in an exception being thrown.
     *
     * @dataProvider invalidDnsRecordDataProvider
     *
     * @param string $type
     *   The type of DNS record (A, AAAA, CNAME).
     * @param string $value
     *   The value of the DNS record (IPv4 address, IPv6 address, CNAME).
     */
    public function testInstanceNamePropertyMustBeAnAlphanumericString(string $type, string $value)
    {
        $this->expectException('InvalidArgumentException');
        $dnsRecord = new DnsRecord($type, $value);
    }
}
