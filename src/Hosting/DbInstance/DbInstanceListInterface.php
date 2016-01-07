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

interface DbInstanceListInterface
{
    /**
     * Returns a subset of known servers matching the provided instance names
     *
     * @param array|string $names An array of server names, or a comma-
     *                            delimited string of application names.
     *
     * @return DbInstanceListInterface
     */
    public function filterByName($names);
}
