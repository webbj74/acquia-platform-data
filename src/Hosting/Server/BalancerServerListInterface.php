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

interface BalancerServerListInterface extends ServerListInterface
{
    /**
     * Return list of balancers that are currently active.
     *
     * @return BalancerServerListInterface
     */
    public function getActiveBalancers();
}
