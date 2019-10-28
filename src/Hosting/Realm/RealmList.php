<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Realm;

use Acquia\Platform\Cloud\Hosting\RealmInterface;
use ArrayObject;
use InvalidArgumentException;

class RealmList extends ArrayObject implements RealmListInterface
{
    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Overrides ArrayObject::offsetSet() to validate that the value set at the
     * specified offset is a Realm.
     *
     * No value is returned.
     *
     * @param mixed $offset
     * @param RealmInterface $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_subclass_of($value, 'Acquia\Platform\Cloud\Hosting\RealmInterface')) {
            throw new InvalidArgumentException(
                sprintf('%s: $value must be an implementation of RealmInterface', __METHOD__)
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

        $filteredRealmList = new static();
        $iterator = $this->getIterator();
        while ($iterator->valid()) {
            if (in_array($iterator->current()->getName(), $names)) {
                $filteredRealmList->append($iterator->current());
            }
            $iterator->next();
        }

        return $filteredRealmList;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultRealms()
    {
        $filteredRealmList = new static();
        $iterator = $this->getIterator();
        while ($iterator->valid()) {
            if ($iterator->current()->isDefault()) {
                $filteredRealmList->append($iterator->current());
            }
            $iterator->next();
        }

        return $filteredRealmList;
    }
}
