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
}
