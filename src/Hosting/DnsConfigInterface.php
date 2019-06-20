<?php

/**
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting;

/**
 * Interface DnsConfigInterface.
 */
interface DnsConfigInterface
{
    /**
     * Return the type of DNS record (A, AAAA, CNAME).
     *
     * @return string
     *   The type of the DNS record.
     */
    public function getType(): string;

    /**
     * Return the value of the DNS record (IPv4 address, IPv6 address, CNAME).
     *
     * @return string
     *   The value of the DNS record.
     */
    public function getValue(): string;
}
