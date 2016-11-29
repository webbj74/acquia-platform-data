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

interface MonitorListInterface
{
    /**
     * Appends a new value as the last element.
     *
     * @param mixed $value The value passed should implement MonitorInterface.
     */
    public function append($value);

    /**
     * Returns one or more reporting URLs for the monitor.
     *
     * For example:
     *   Array(
     *      'nagios' => [
     *          0 => 'http://my.nagios/interface',
     *          1 => 'http://your.nagios/interface',
     *      ],
     *      'statuscheck' => [
     *          0 => 'http://statuscheck.example.com',
     *      ],
     *   )
     *
     * @param string|null $monitorName The name of the monitor to return URLs.
     *
     * @return array An array of strings, each representing a URL.
     */
    public function getMonitoringUrls($monitorName = null);

    /**
     * Returns an array representation of the monitor(s).
     *
     * For example:
     *   Array(
     *      'nagios' => [
     *          'name' => 'nagios',
     *          'status' => 'disabled',
     *          'urls' => [
     *              0 => 'http://my.nagios/interface',
     *              1 => 'http://your.nagios/interface',
     *          ],
     *      ],
     *   )
     *
     * @param string|null $monitorName The name of the monitor to return.
     *
     * @return array An array of monitor data, keyed by monitor name.
     */
    public function getArrayCopy($monitorName = null);
}
