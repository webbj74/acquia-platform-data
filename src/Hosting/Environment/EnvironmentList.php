<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Environment;

final class EnvironmentList extends \ArrayObject implements EnvironmentListInterface
{
    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Overrides ArrayObject::offsetSet() to validate that the value set at the
     * specified offset is an Environment.
     *
     * No value is returned.
     *
     * @param mixed $offset
     * @param \Acquia\Platform\Cloud\Hosting\EnvironmentInterface $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_subclass_of($value, 'Acquia\Platform\Cloud\Hosting\EnvironmentInterface')) {
            throw new \InvalidArgumentException(
                sprintf('%s: $value must be an implementation of EnvironmentInterface', __METHOD__)
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

        $filteredList = new static();
        $iterator = $this->getIterator();
        while ($iterator->valid()) {
            if (in_array($iterator->current()->getName(), $names)) {
                $filteredList->append($iterator->current());
            }
            $iterator->next();
        }

        return $filteredList;
    }
}
