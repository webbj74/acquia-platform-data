<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\DbInstance;

use Acquia\Platform\Cloud\Hosting\DbInstanceInterface;

class DbInstanceList extends \ArrayObject implements DbInstanceListInterface
{
    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Overrides ArrayObject::offsetSet() to validate that the value set at the
     * specified offset is a DbInstance.
     *
     * No value is returned.
     *
     * @param mixed $offset
     * @param DbInstanceInterface $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_subclass_of($value, 'Acquia\Platform\Cloud\Hosting\DbInstanceInterface')) {
            throw new \InvalidArgumentException(
                sprintf('%s: $value must be an implementation of DbInstanceInterface', __METHOD__)
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

        $filteredDbInstanceList = new static();
        $appListIterator = $this->getIterator();
        while ($appListIterator->valid()) {
            if (in_array($appListIterator->current()->getInstanceName(), $names)) {
                $filteredDbInstanceList->append($appListIterator->current());
            }
            $appListIterator->next();
        }

        return $filteredDbInstanceList;
    }
}
