<?php

/**
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\DnsRecord;

/**
 * Interface DnsRecordListInterface.
 */
interface DnsRecordListInterface
{
    /**
     * Return a DnsRecordList containing all A (IPv4) DnsRecord objects.
     *
     * @return DnsRecordList A list of A records.
     *   A list of A records.
     */
    public function getARecords(): DnsRecordList;

    /**
     * Return a DnsRecordList containing all AAAA (IPv6) DnsRecord objects.
     *
     * @return DnsRecordList A list of AAAA records.
     *   A list of AAAA records.
     */
    public function getAaaaRecords(): DnsRecordList;

    /**
     * Return a DnsRecordList containing all CNAME DnsRecord objects.
     *
     * @return DnsRecordList A list of CNAME records.
     *   A list of CNAME records.
     */
    public function getCnameRecords(): DnsRecordList;
}
