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

interface ApplicationListInterface
{
    /**
     * Returns a subset of known applications matching the provided names
     *
     * @param array|string $names An array of application names, or a comma-
     *                            delimited string of application names.
     *
     * @return ApplicationListInterface
     */
    public function filterByName($names);
}
