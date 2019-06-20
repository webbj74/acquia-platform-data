<?php

/**
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\DnsConfig;

/**
 * Interface DnsConfigListInterface.
 */
interface DnsConfigListInterface
{
    /**
     * Return a DnsConfigList containing all A (IPv4) DnsConfig objects.
     *
     * @return \Acquia\Platform\Cloud\Hosting\DnsConfig\DnsConfigList
     *   A list of A records.
     */
    public function getARecords(): DnsConfigList;

    /**
     * Return a DnsConfigList containing all AAAA (IPv6) DnsConfig objects.
     *
     * @return \Acquia\Platform\Cloud\Hosting\DnsConfig\DnsConfigList
     *   A list of AAAA records.
     */
    public function getAaaaRecords(): DnsConfigList;

    /**
     * Return a DnsConfigList containing all CNAME DnsConfig objects.
     *
     * @return \Acquia\Platform\Cloud\Hosting\DnsConfig\DnsConfigList
     *   A list of CNAME records.
     */
    public function getCnameRecords(): DnsConfigList;
}
