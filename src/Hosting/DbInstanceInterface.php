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

/**
 * A DbInstance corresponds to an instance of a database for a client's
 * application . It contains:
 * - An instance name, internal to Acquia, eg. userdevdb1234
 * - A public name, eg. mysite
 * - A DB username, eg. user123
 * - A DB password, eg. hunter2
 * - A host name, eg. staging-1234
 * - A DB Cluster ID, eg. 1234
 */
interface DbInstanceInterface
{
    /**
     * Factory method for DbInstance classes.
     *
     * @param array $dbInstanceData
     *
     * @return DbInstanceInterface
     */
    public static function create(array $dbInstanceData);

    /**
     * Returns the internal instance name of the dbinstance.
     *
     * @return string The internal instance name of the dbinstance.
     */
    public function getInstanceName();

    /**
     * Returns the public name of the database.
     *
     * @return string The public name of the database.
     */
    public function getName();

    /**
     * Sets the name of the dbinstance.
     *
     * @param string $name The name of the dbinstance.
     */
    public function setName($name);

    /**
     * Returns the username for the database.
     *
     * @return string The username for the database.
     */
    public function getUsername();

    /**
     * Sets the username for the dbinstance.
     *
     * @param string $username The username for the dbinstance.
     */
    public function setUsername($username);

    /**
     * Returns the password for the database.
     *
     * @return string The password for the database.
     */
    public function getPassword();

    /**
     * Sets the password for the dbinstance.
     *
     * @param string $password The password for the dbinstance.
     */
    public function setPassword($password);

    /**
     * Returns the host for the database.
     *
     * @return string The host for the database.
     */
    public function getHost();

    /**
     * Sets the host for the dbinstance.
     *
     * @param string $host The host for the database.
     */
    public function setHost($host);

    /**
     * Returns the cluster ID for the database.
     *
     * @return int The cluster ID for the database.
     */
    public function getClusterID();

    /**
     * Sets the cluster ID for the dbinstance.
     *
     * @param int $clusterID The cluster ID for the dbinstance.
     */
    public function setClusterID($clusterID);
}
