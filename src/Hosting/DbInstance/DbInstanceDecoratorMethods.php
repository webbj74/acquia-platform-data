<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\DbInstance;

use Acquia\Platform\Cloud\Hosting\DbInstanceInterface;

trait DbInstanceDecoratorMethods
{
    /**
     * @var DbInstanceInterface
     */
    protected $dbInstance;

    /**
     * Returns the decorated dbInstance instance.
     *
     * @return DbInstanceInterface the decorated DbInstance
     */
    public function getDbInstance()
    {
        return $this->dbInstance;
    }

    /**
     * Sets the dbInstance instance being decorated.
     *
     * @param DbInstanceInterface $dbInstance the DbInstance to decorate
     */
    public function setDbInstance(DbInstanceInterface $dbInstance)
    {
        $this->dbInstance = $dbInstance;
    }

    /**
     * {@inheritdoc}
     */
    public function getInstanceName()
    {
        return $this->dbInstance->getInstanceName();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->dbInstance->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->dbInstance->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->dbInstance->getUsername();
    }

    /**
     * {@inheritdoc}
     */
    public function setUsername($username)
    {
        $this->dbInstance->setUsername($username);
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->dbInstance->getPassword();
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword($password)
    {
        $this->dbInstance->setPassword($password);
    }

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        return $this->dbInstance->getHost();
    }

    /**
     * {@inheritdoc}
     */
    public function setHost($host)
    {
        $this->dbInstance->setHost($host);
    }

    /**
     * {@inheritdoc}
     */
    public function getClusterID()
    {
        return $this->dbInstance->getClusterID();
    }

    /**
     * {@inheritdoc}
     */
    public function setClusterID($clusterID)
    {
        $this->dbInstance->setClusterID($clusterID);
    }

}
