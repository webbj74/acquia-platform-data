<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Task;

use Acquia\Platform\Cloud\Hosting\TaskInterface;

class TaskList extends \ArrayObject implements TaskListInterface
{
    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Overrides ArrayObject::offsetSet() to validate that the value set at the
     * specified offset is a Task.
     *
     * No value is returned.
     *
     * @param mixed $offset
     * @param TaskInterface $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_subclass_of($value, 'Acquia\Platform\Cloud\Hosting\TaskInterface')) {
            throw new \InvalidArgumentException(
                sprintf('%s: $value must be an implementation of TaskInterface', __METHOD__)
            );
        }
        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function filterByIDs($ids)
    {
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        if (!is_array($ids)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $ids must be an array (or comma-delimited string)', __METHOD__)
            );
        }

        $filteredTaskList = new static();
        $appListIterator = $this->getIterator();
        while ($appListIterator->valid()) {
            if (in_array($appListIterator->current()->getName(), $ids)) {
                $filteredTaskList->append($appListIterator->current());
            }
            $appListIterator->next();
        }

        return $filteredTaskList;
    }
}
