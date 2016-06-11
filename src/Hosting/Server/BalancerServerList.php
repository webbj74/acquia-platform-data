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

use Acquia\Platform\Cloud\Hosting\ServerInterface;

class BalancerServerList extends ServerList implements BalancerServerListInterface
{
    /**
     * {@inheritdoc}
     *
     * This implementation is based on data returned from Cloud API
     */
    public function getActiveBalancers()
    {
        $activeBalancers = new static;

        /** @var ServerInterface $balancer */
        foreach ($this as $balancer) {
            $services = $balancer->getServices();
            if (empty($services['varnish']) || empty($services['varnish']['status'])) {
                continue;
            }
            if ($services['varnish']['status'] != 'active') {
                continue;
            }
            $activeBalancers->append($balancer);
        }

        return $activeBalancers;
    }
}
