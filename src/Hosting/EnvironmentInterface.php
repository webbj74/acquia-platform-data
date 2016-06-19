<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting;

use Acquia\Platform\Cloud\Hosting\Server\ServerListInterface;

interface EnvironmentInterface
{
    /**
     * Factory method for Environment classes.
     *
     * Deprecated in favor of EnvironmentFactory method(s).
     *
     * @param array $environmentData
     *
     * @return EnvironmentInterface
     *
     * @deprecated
     */
    public static function create(array $environmentData);

    /**
     * Returns the human readable name of the environment. Examples:
     * - test
     * - prod
     *
     * @return string The human readable name of the environment.
     */
    public function getName();

    /**
     * Returns the VCS revision which is deployed on this environment.
     *
     * @return string
     */
    public function getRevision();

    /**
     * Sets the VCS revision which is deployed on this environment.
     *
     * @param string $revision
     */
    public function setRevision($revision);

    /**
     * Returns default hostname to connect to in this environment.
     *
     * @return string
     */
    public function getDefaultHostName();

    /**
     * Sets the default hostname to connect to in this environment.
     *
     * @param string $defaultHostName
     */
    public function setDefaultHostName($defaultHostName);

    /**
     * Returns an array of Acquia Platform database cluster IDs used with this environment.
     *
     * @return array
     */
    public function getDatabaseClusterList();

    /**
     * Assigns an array of Acquia Platform database cluster IDs used with this environment.
     *
     * @param array $databaseClusterList
     */
    public function setDatabaseClusterList(array $databaseClusterList);

    /**
     * Returns the default acquia-sites.com subdomain provisioned for this environment.
     *
     * @return string
     */
    public function getDefaultDomainName();

    /**
     * Sets the default acquia-sites.com subdomain provisioned for this environment.
     *
     * @param string $defaultDomainName
     */
    public function setDefaultDomainName($defaultDomainName);

    /**
     * Returns true if the environment is in Live Development mode.
     *
     * @return bool
     */
    public function isInLiveDev();

    /**
     * Indicate whether the environment is in Live Development mode.
     *
     * @param bool $inLiveDevelopment
     */
    public function setInLiveDev($inLiveDevelopment);

    /**
     * Returns the UNIX user name to connect to the environment with.
     *
     * @return string
     */
    public function getUnixUserName();

    /**
     * Assigns the UNIX user name to connect to the environment with.
     *
     * @param string $unixUserName
     */
    public function setUnixUserName($unixUserName);

    /**
     * Returns the machine name of the environment.
     *
     * @return string
     */
    public function getMachineName();

    /**
     * Assigns the machine name of the environment.
     *
     * @param string $machineName
     */
    public function setMachineName($machineName);

    /**
     * Assign a list of servers to the environment.
     *
     * @param ServerListInterface $serverList
     */
    public function setServerList(ServerListInterface $serverList);

    /**
     * Returns a list of servers assigned to this environment.
     *
     * @return ServerListInterface
     */
    public function getServerList();

    /**
     * Returns the application.environment name of the environment.
     *
     * @return string
     */
    public function getApplicationQualifiedName();

    /**
     * Returns the path of the DocumentRoot for this environment.
     *
     * @return string
     */
    public function getDocumentRootPath();
}
