<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Monitor;

use ArrayObject;
use InvalidArgumentException;

class MonitorList extends ArrayObject implements MonitorListInterface
{
    /**
     * {@inheritdoc}
     *
     * Adds additional type checking to ensure a Monitor is passed.
     */
    public function offsetSet($index, $newval)
    {
        if (!is_subclass_of($newval, 'Acquia\Platform\Cloud\Hosting\Monitor\MonitorInterface')) {
            throw new InvalidArgumentException(
                sprintf('%s: $newval must be an implementation of MonitorInterface', __METHOD__)
            );
        }
        parent::offsetSet($index, $newval);
    }

    /**
     * {@inheritdoc}
     */
    public function getMonitoringUrls($monitorName = null)
    {
        $urls = [];

        /** @var MonitorInterface $monitor */
        foreach ($this as $monitor) {
            if ($monitorName && $monitorName !== $monitor->getName()) {
                continue;
            }
            $urls[$monitor->getName()] = $monitor->getMonitoringUrls();
        }
        
        return $urls;
    }

    /**
     * {@inheritdoc}
     */
    public function getArrayCopy($monitorName = null)
    {
        $copy = [];

        /** @var MonitorInterface $monitor */
        foreach ($this as $monitor) {
            if ($monitorName && $monitorName !== $monitor->getName()) {
                continue;
            }
            $copy[$monitor->getName()] = $monitor->getArrayCopy();
        }
        
        return $copy;
    }
}
