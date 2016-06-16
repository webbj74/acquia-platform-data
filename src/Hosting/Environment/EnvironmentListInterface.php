<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Environment;

use Acquia\Platform\Cloud\Hosting\EnvironmentInterface;

interface EnvironmentListInterface
{
    /**
     * Returns a subset of known environments matching the provided names
     *
     * @param array|string $names An array of environments names, or a comma-delimited string of names
     *
     * @return EnvironmentListInterface
     */
    public function filterByName($names);

    /**
     * Retrieves an environment object by its machine name.
     *
     * @param $name
     *
     * @return EnvironmentInterface
     */
    public function getEnvironmentByMachineName($name);

    /**
     * Retrieves an environment object by its application.environment name.
     *
     * @param $name
     *
     * @return EnvironmentInterface
     */
    public function getEnvironmentByApplicationQualifiedName($name);

    /**
     * Returns a simple array of environment names.
     *
     * @return array Associative array of Environments in the form envName => machineName
     */
    public function getNames();
}
