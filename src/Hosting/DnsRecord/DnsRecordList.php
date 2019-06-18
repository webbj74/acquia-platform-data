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

use Acquia\Platform\Cloud\Hosting\DnsRecord;
use InvalidArgumentException;

/**
 * Class DnsRecordList.
 */
class DnsRecordList extends \ArrayObject implements DnsRecordListInterface
{
    /**
     * Validate that appended records are DnsRecord objects.
     *
     * @param DnsRecord $value
     */
    public function append($value)
    {
        if (!$value instanceof DnsRecord) {
            throw new InvalidArgumentException('$value must be an instance of DnsRecord');
        }
        parent::append($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getARecords(): DnsRecordList
    {
        return $this->filterByTypes(['A']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAaaaRecords(): DnsRecordList
    {
        return $this->filterByTypes(['AAAA']);
    }

    /**
     * {@inheritdoc}
     */
    public function getCnameRecords(): DnsRecordList
    {
        return $this->filterByTypes(['CNAME']);
    }

    /**
     * Return a subset of the DnsRecordList filtered by one or more types.
     *
     * @param string[] $types
     *   An array of the types to filter (A, AAAA, CNAME).
     *
     * @return DnsRecordList A list of DNS records.
     *   A list of DNS records.
     */
    protected function filterByTypes(array $types): DnsRecordList
    {
        $filteredDnsrecords = new static();

        $listIterator = $this->getIterator();
        while ($listIterator->valid()) {
            if (in_array($listIterator->current()->getType(), $types)) {
                $filteredDnsrecords->append($listIterator->current());
            }
            $listIterator->next();
        }

        return $filteredDnsrecords;
    }
}
