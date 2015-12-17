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

trait EnvironmentDecoratorMethods
{
    /**
     * @var EnvironmentInterface
     */
    protected $environment;

    /**
     * Returns the decorated environment instance.
     *
     * @return EnvironmentInterface the decorated Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Sets the environment instance being decorated.
     *
     * @param EnvironmentInterface $environment the Environment to decorate
     */
    public function setEnvironment(EnvironmentInterface $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->environment->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getRevision()
    {
        return $this->environment->getRevision();
    }

    /**
     * {@inheritdoc}
     */
    public function setRevision($revision)
    {
        $this->environment->setRevision($revision);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultHostName()
    {
        return $this->environment->getDefaultHostName();
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultHostName($defaultHostName)
    {
        $this->environment->setDefaultHostName($defaultHostName);
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabaseClusterList()
    {
        return $this->environment->getDatabaseClusterList();
    }

    /**
     * {@inheritdoc}
     */
    public function setDatabaseClusterList(array $databaseClusterList)
    {
        $this->environment->setDatabaseClusterList($databaseClusterList);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDomainName()
    {
        return $this->environment->getDefaultDomainName();
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultDomainName($defaultDomainName)
    {
        $this->environment->setDefaultDomainName($defaultDomainName);
    }

    /**
     * {@inheritdoc}
     */
    public function isInLiveDev()
    {
        return $this->environment->isInLiveDev();
    }

    /**
     * {@inheritdoc}
     */
    public function setInLiveDev($inLiveDevelopment)
    {
        $this->environment->setInLiveDev($inLiveDevelopment);
    }

    /**
     * {@inheritdoc}
     */
    public function getUnixUserName()
    {
        return $this->environment->getUnixUserName();
    }

    /**
     * {@inheritdoc}
     */
    public function setUnixUserName($unixUserName)
    {
        $this->environment->setUnixUserName($unixUserName);
    }

    /**
     * {@inheritdoc}
     */
    public function getMachineName()
    {
        return $this->environment->getMachineName();
    }

    /**
     * {@inheritdoc}
     */
    public function setMachineName($machineName)
    {
        $this->environment->setMachineName($machineName);
    }
}
