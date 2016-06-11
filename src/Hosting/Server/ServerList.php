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

class ServerList extends \ArrayObject implements ServerListInterface
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
            throw new \InvalidArgumentException(
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
            throw new \InvalidArgumentException(
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
     */
    public function getLowestNumberedServer()
    {
        $lowestServer = null;
        $lowestId = 999999;

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
}
