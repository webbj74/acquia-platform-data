<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Application;

use Acquia\Platform\Cloud\Hosting\ApplicationInterface;
use ArrayObject;
use InvalidArgumentException;

class ApplicationList extends ArrayObject implements ApplicationListInterface
{
    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Overrides ArrayObject::offsetSet() to validate that the value set at the
     * specified offset is a Application.
     *
     * No value is returned.
     *
     * @param mixed $offset
     * @param ApplicationInterface $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_subclass_of($value, 'Acquia\Platform\Cloud\Hosting\ApplicationInterface')) {
            throw new InvalidArgumentException(
                sprintf('%s: $value must be an implementation of ApplicationInterface', __METHOD__)
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
            throw new InvalidArgumentException(
                sprintf('%s: $names must be an array (or comma-delimited string)', __METHOD__)
            );
        }

        $filteredAppList = new static();
        $appListIterator = $this->getIterator();
        while ($appListIterator->valid()) {
            if (in_array($appListIterator->current()->getName(), $names)) {
                $filteredAppList->append($appListIterator->current());
            }
            $appListIterator->next();
        }

        return $filteredAppList;
    }
}
