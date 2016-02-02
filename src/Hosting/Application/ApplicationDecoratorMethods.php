<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Application;

use Acquia\Platform\Cloud\Hosting\ApplicationInterface;
use Acquia\Platform\Cloud\Hosting\Environment\EnvironmentListInterface;
use Acquia\Platform\Cloud\Hosting\RealmInterface;

trait ApplicationDecoratorMethods
{
    /**
     * @var ApplicationInterface
     */
    protected $application;

    /**
     * Returns the decorated application instance.
     *
     * @return ApplicationInterface the decorated Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Sets the application instance being decorated.
     *
     * @param ApplicationInterface $application the Application to decorate
     */
    public function setApplication(ApplicationInterface $application)
    {
        $this->application = $application;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->application->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getRealmQualifiedName()
    {
        return $this->application->getRealmQualifiedName();
    }

    /**
     * {@inheritdoc}
     */
    public function getVcsType()
    {
        return $this->application->getVcsType();
    }

    /**
     * {@inheritdoc}
     */
    public function setVcsType($vcsType)
    {
        $this->application->setVcsType($vcsType);
    }

    /**
     * {@inheritdoc}
     */
    public function getVcsRepositoryUrl()
    {
        return $this->application->getVcsRepositoryUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function setVcsRepositoryUrl($vcsUrl)
    {
        $this->application->setVcsRepositoryUrl($vcsUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function isInProduction()
    {
        return $this->application->isInProduction();
    }

    /**
     * {@inheritdoc}
     */
    public function setProductionMode($productionMode)
    {
        $this->application->setProductionMode($productionMode);
    }

    /**
     * {@inheritdoc}
     */
    public function getUnixUsername()
    {
        return $this->application->getUnixUsername();
    }

    /**
     * {@inheritdoc}
     */
    public function setUnixUsername($unixUsername)
    {
        $this->application->setUnixUsername($unixUsername);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->application->getTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->application->setTitle($title);
    }

    /**
     * {@inheritdoc}
     */
    public function getUUID()
    {
        return $this->application->getUUID();
    }

    /**
     * {@inheritdoc}
     */
    public function setUUID($uuid)
    {
        $this->application->setUUID($uuid);
    }

    /**
     * {@inheritdoc}
     */
    public function getRealm()
    {
        return $this->application->getRealm();
    }

    /**
     * {@inheritdoc}
     */
    public function setRealm(RealmInterface $realm)
    {
        $this->application->setRealm($realm);
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironmentList()
    {
        return $this->application->getEnvironmentList();
    }

    /**
     * {@inheritdoc}
     */
    public function setEnvironmentList(EnvironmentListInterface $environmentList)
    {
        $this->application->setEnvironmentList($environmentList);
    }
}
