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

use Acquia\Platform\Cloud\Hosting\DnsConfig;
use InvalidArgumentException;

/**
 * Class DnsConfigList.
 */
class DnsConfigList extends \ArrayObject implements DnsConfigListInterface
{
    /**
     * Validate that appended records are DnsConfig objects.
     *
     * @param \Acquia\Platform\Cloud\Hosting\DnsConfig $value
     */
    public function append($value)
    {
        if (!$value instanceof DnsConfig) {
            throw new InvalidArgumentException('$value must be an instance of DnsConfig');
        }
        parent::append($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getARecords(): DnsConfigList
    {
        return $this->filterByTypes(['A']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAaaaRecords(): DnsConfigList
    {
        return $this->filterByTypes(['AAAA']);
    }

    /**
     * {@inheritdoc}
     */
    public function getCnameRecords(): DnsConfigList
    {
        return $this->filterByTypes(['CNAME']);
    }

    /**
     * Return a subset of the DnsConfigList filtered by one or more types.
     *
     * @param string[] $types
     *   An array of the types to filter (A, AAAA, CNAME).
     *
     * @return \Acquia\Platform\Cloud\Hosting\DnsConfig\DnsConfigList
     *   A list of DNS records.
     */
    protected function filterByTypes(array $types): DnsConfigList
    {
        $filteredDnsConfigs = new static();

        $listIterator = $this->getIterator();
        while ($listIterator->valid()) {
            if (in_array($listIterator->current()->getType(), $types)) {
                $filteredDnsConfigs->append($listIterator->current());
            }
            $listIterator->next();
        }

        return $filteredDnsConfigs;
    }
}
