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

    /**
     * Returns the lowest numbered server in the list.
     *
     * @return ServerInterface
     */
    public function getLowestNumberedServer();


    /**
     * Returns a list of load balancer servers
     *
     * @return BalancerServerListInterface
     */
    public function getBalancerServers();

    /**
     * Returns a list of database servers
     *
     * @return DatabaseServerListInterface
     */
    public function getDatabaseServers();

    /**
     * Returns list of file servers.
     *
     * @return FileServerListInterface
     */
    public function getFileServers();

    /**
     * Returns a list of vcs servers
     *
     * @return VcsServerListInterface
     */
    public function getVcsServers();

    /**
     * Returns a list of web servers
     *
     * @return WebServerListInterface
     */
    public function getWebServers();
}
