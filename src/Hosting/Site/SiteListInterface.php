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

interface SiteListInterface
{
    /**
     * Returns a subset of known sites matching the provided names
     *
     * @param array|string $names An array of site names, or a comma-delimited string of names
     *
     * @return SiteListInterface
     */
    public function filterByName($names);
}
