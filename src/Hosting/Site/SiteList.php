<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Site;

class SiteList extends \ArrayObject implements SiteListInterface
{
    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Overrides ArrayObject::offsetSet() to validate that the value set at the
     * specified offset is a Site.
     *
     * No value is returned.
     *
     * @param mixed $offset
     * @param SiteInterface $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_subclass_of($value, 'Acquia\Platform\Cloud\Hosting\SiteInterface')) {
            throw new \InvalidArgumentException(
                sprintf('%s: $value must be an implementation of SiteInterface', __METHOD__)
            );
        }
        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function filterByName($names)
    {
        if (is_string($names)) {
            $names = explode(',', $names);
        }

        if (!is_array($names)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $names must be an array (or comma-delimited string)', __METHOD__)
            );
        }

        $filteredSiteList = new static();
        $iterator = $this->getIterator();
        while ($iterator->valid()) {
            if (in_array($iterator->current()->getName(), $names)) {
                $filteredSiteList->append($iterator->current());
            }
            $iterator->next();
        }

        return $filteredSiteList;
    }
}
