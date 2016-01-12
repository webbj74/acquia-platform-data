<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Server;

interface ServerListInterface
{
    /**
     * Returns a subset of known servers matching the provided names
     *
     * @param array|string $names An array of server names, or a comma-
     *                            delimited string of server names.
     *
     * @return ServerListInterface
     */
    public function filterByName($names);
}
