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

interface MonitorInterface
{
    /**
     * Returns the monitor name.
     *
     * @return string
     *   The name of the monitor.
     */
    public function getName();

    /**
     * Returns the monitor status.
     *
     * @return string
     *   The status of the monitor.
     */
    public function getStatus();

    /**
     * Returns one or more reporting URLs for the monitor.
     *
     * @return array
     *   An array of strings, each representing a URL.
     */
    public function getMonitoringUrls();

    /**
     * Returns an array representation of the object.
     *
     * For example:
     *   Array(
     *      'name' => 'nagios',
     *      'status' => 'disabled',
     *      'urls' => [
     *          0 => 'http://my.nagios/interface',
     *          1 => 'http://your.nagios/interface',
     *      ],
     *   )
     *
     * @return array
     *   An array representing the object.
     */
    public function getArrayCopy();
}
