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

interface TaskListInterface
{
    /**
     * Returns a subset of known tasks matching the provided IDs
     *
     * @param array|string $ids An array of task IDs, or a comma-
     *                            delimited string of task IDs.
     *
     * @return TaskListInterface
     */
    public function filterByIDs($ids);
}
