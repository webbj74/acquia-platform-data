<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Server;

use Acquia\Platform\Cloud\Hosting\Server;
use Acquia\Platform\Cloud\Hosting\Server\BalancerServerList;
use Acquia\Platform\Cloud\Hosting\Server\BalancerServerListInterface;
use Acquia\Platform\Cloud\Hosting\ServerInterface;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Server\BalancerServerList
 */
class BalancerServerListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getActiveBalancers
     */
    public function testgetActiveBalancers()
    {
        $serverList = new BalancerServerList();
        $serverList->append(Server::create([
            'name' => 'bal-123',
            'services' => [
                'varnish' => ['status' => 'active'],
            ],
        ]));
        $serverList->append(Server::create([
            'name' => 'bal-234',
            'services' => [
                'varnish' => ['status' => 'hot_spare'],
            ],
        ]));
        $serverList->append(Server::create([
            'name' => 'bal-345',
            'services' => [],
        ]));
        $this->assertEquals(3, count($serverList));

        /** @var BalancerServerListInterface $activeBals */
        $activeBals = $serverList->getActiveBalancers();
        $this->assertEquals(1, count($activeBals));

        /** @var ServerInterface $activeBal */
        $activeBal = $activeBals[0];
        $this->assertEquals('bal-123', $activeBal->getName());
    }
}
