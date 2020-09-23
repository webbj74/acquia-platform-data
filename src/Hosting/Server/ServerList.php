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
use ArrayObject;
use InvalidArgumentException;
use RuntimeException;

class ServerList extends ArrayObject implements ServerListInterface
{
    /**
     * Implementation of ArrayAccess::offsetGet()
     *
     * Overrides ArrayObject::offsetGet() to allow using server name as key.
     *
     * @param int|string $index
     *
     * @return ServerInterface|null
     */
    public function offsetGet($index)
    {
        if (is_numeric($index)) {
            return parent::offsetGet($index);
        }

        $matchingServer = null;

        /** @var ServerInterface $server */
        foreach ($this as $server) {
            if ($server->getName() === $index) {
                $matchingServer = $server;
                break;
            }
        }
        return $matchingServer;
    }

    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Overrides ArrayObject::offsetSet() to validate that the value set at the
     * specified offset is a Server.
     *
     * No value is returned.
     *
     * @param mixed $offset
     * @param ServerInterface $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_subclass_of($value, 'Acquia\Platform\Cloud\Hosting\ServerInterface')) {
            throw new InvalidArgumentException(
                sprintf('%s: $value must be an implementation of ServerInterface', __METHOD__)
            );
        }
        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function filterByName($names)
    {
        if (is_string($names)) {
            $names = explode(',', $names);
        }

        if (!is_array($names)) {
            throw new InvalidArgumentException(
                sprintf('%s: $names must be an array (or comma-delimited string)', __METHOD__)
            );
        }

        $filteredServerList = new static();
        $serverListIterator = $this->getIterator();
        while ($serverListIterator->valid()) {
            if (in_array($serverListIterator->current()->getName(), $names)) {
                $filteredServerList->append($serverListIterator->current());
            }
            $serverListIterator->next();
        }

        return $filteredServerList;
    }

    /**
     * {@inheritdoc}
     *
     * PHPMD is incorrectly flagging $matches as an undefined variable.
     * @see https://github.com/phpmd/phpmd/issues/672
     *
     * @SuppressWarnings(PHPMD.UndefinedVariable)
     */
    public function getLowestNumberedServer()
    {
        $lowestServer = null;
        $lowestId = 999999;

        if (!$this->count()) {
            throw new RuntimeException(
                "There are no servers in this ServerList to choose from.",
            );
        }

        /** @var ServerInterface $server */
        foreach ($this as $server) {
            preg_match('/^[^-]+-(\d+)$/', $server->getName(), $matches);
            if (isset($matches[1]) && intval($matches[1]) < $lowestId && intval($matches[1]) > 0) {
                $lowestServer = $server;
                $lowestId = $matches[1];
            }
        }

        return $lowestServer;
    }

    /**
     * {@inheritdoc}
     */
    public function getBalancerServers()
    {
        $balancerServers = new BalancerServerList();

        /** @var ServerInterface $server */
        foreach ($this as $server) {
            if ($server->isBalancerServer()) {
                $balancerServers->append($server);
            }
        }

        return $balancerServers;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabaseServers()
    {
        $databaseServers = new DatabaseServerList();

        /** @var ServerInterface $server */
        foreach ($this as $server) {
            if ($server->isDatabaseServer()) {
                $databaseServers->append($server);
            }
        }

        return $databaseServers;
    }

    /**
     * {@inheritdoc}
     *
     * Cloud API doesn't explicitly tell if the server is a fileserver, so
     * make an educated guess based on the server name or other services that
     * are provided.
     */
    public function getFileServers()
    {
        $fileServers = new FileServerList();
        $databaseServers = new FileServerList();

        /** @var ServerInterface $server */
        foreach ($this as $server) {
            if ($server->isFileServer()) {
                $fileServers->append($server);
                continue;
            }
            if ($server->isDatabaseServer()) {
                $databaseServers->append($server);
                continue;
            }
        }

        if (!$fileServers->count()) {
            $fileServers = $databaseServers;
        }

        return $fileServers;
    }

    /**
     * {@inheritdoc}
     */
    public function getVcsServers()
    {
        $vcsServers = new VcsServerList();

        /** @var ServerInterface $server */
        foreach ($this as $server) {
            if ($server->isVcsServer()) {
                $vcsServers->append($server);
            }
        }

        return $vcsServers;
    }

    /**
     * {@inheritdoc}
     */
    public function getWebServers()
    {
        $webServers = new WebServerList();

        /** @var ServerInterface $server */
        foreach ($this as $server) {
            if ($server->isWebServer()) {
                $webServers->append($server);
            }
        }

        return $webServers;
    }
}
