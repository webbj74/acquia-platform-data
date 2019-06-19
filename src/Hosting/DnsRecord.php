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

use InvalidArgumentException;

/**
 * Class DnsRecord.
 */
class DnsRecord implements DnsRecordInterface
{
    /**
     * Supported DNS record types.
     *
     * @var string[]
     */
    public const SUPPORTED_TYPES = [
        'A',
        'AAAA',
        'CNAME',
    ];

    /**
     * The type of DNS record (A, AAAA, CNAME).
     *
     * @var string
     */
    protected $type;

    /**
     * The value of the DNS record (IPv4 address, IPv6 address, CNAME).
     *
     * @var string
     */
    protected $value;

    /**
     * DnsRecord constructor.
     *
     * @param string $type
     *   The type of DNS record (A, AAAA, CNAME).
     * @param string $value
     *   The value of the DNS record (IPv4 address, IPv6 address, CNAME).
     */
    public function __construct(string $type, string $value)
    {
        // Validate record type.
        if (!in_array($type, self::SUPPORTED_TYPES)) {
            throw new InvalidArgumentException(sprintf(
                '$type must be one of %s; %s provided.',
                implode(', ', self::SUPPORTED_TYPES),
                $type
            ));
        }
        $this->type = $type;

        // Validate value based on record type.
        if ($type == 'A' && !filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            throw new InvalidArgumentException('$value must be a valid IPv4 address.');
        }
        if ($type == 'AAAA' && !filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            throw new InvalidArgumentException('$value must be a valid IPv6 address.');
        }
        if ($type == 'CNAME' && !filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            throw new InvalidArgumentException('$value must be a valid domain name.');
        }
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
