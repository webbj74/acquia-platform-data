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

use RuntimeException;

trait Monitorable
{
    /**
     * @var MonitorListInterface
     */
    private $monitorList;

    /**
     * Sets up the monitorList for the object.
     *
     * @param MonitorListInterface $monitorList
     */
    public function initializeMonitorList(MonitorListInterface $monitorList = null)
    {
        if (!$monitorList) {
            $monitorList = new MonitorList();
        }
        $this->monitorList = $monitorList;
    }

    /**
     * Adds a monitor to the object.
     *
     * @param MonitorInterface $monitor
     */
    public function addMonitor(MonitorInterface $monitor)
    {
        $monitorList = $this->monitorList;
        if (!$monitorList) {
            throw new RuntimeException('The monitorList has not been initialized.');
        }
        $monitorList->append($monitor);
    }

    /**
     * Returns one or more reporting URLs for the monitor.
     *
     * @param string $monitorName
     *
     * @return array An array of strings, each representing a URL.
     * An array of strings, each representing a URL.
     */
    public function getMonitoringUrls($monitorName = null)
    {
        $monitorList = $this->monitorList;
        if (!$monitorList) {
            throw new RuntimeException('The monitorList has not been initialized.');
        }
        return $monitorList->getMonitoringUrls($monitorName);
    }
}
