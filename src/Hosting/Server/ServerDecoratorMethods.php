<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Server;

use Acquia\Platform\Cloud\Hosting\ServerInterface;

trait ServerDecoratorMethods
{
    /**
     * @var ServerInterface
     */
    protected $server;

    /**
     * Returns the decorated server instance.
     *
     * @return ServerInterface the decorated Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Sets the server instance being decorated.
     *
     * @param ServerInterface $server the Server to decorate
     */
    public function setServer(ServerInterface $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->server->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getFullyQualifiedDomainName()
    {
        return $this->server->getFullyQualifiedDomainName();
    }

    /**
     * {@inheritdoc}
     */
    public function setFullyQualifiedDomainName($fullyQualifiedDomainName)
    {
        $this->server->setFullyQualifiedDomainName($fullyQualifiedDomainName);
    }

    /**
     * {@inheritdoc}
     */
    public function getAmiType()
    {
        return $this->server->getAmiType();
    }

    /**
     * {@inheritdoc}
     */
    public function setAmiType($amiType)
    {
        $this->server->setAmiType($amiType);
    }

    /**
     * {@inheritdoc}
     */
    public function getEc2Region()
    {
        return $this->server->getEc2Region();
    }

    /**
     * {@inheritdoc}
     */
    public function setEc2Region($ec2Region)
    {
        $this->server->setEc2Region($ec2Region);
    }

    /**
     * {@inheritdoc}
     */
    public function getEc2AvailabilityZone()
    {
        return $this->server->getEc2AvailabilityZone();
    }

    /**
     * {@inheritdoc}
     */
    public function setEc2AvailabilityZone($ec2Zone)
    {
        $this->server->setEc2AvailabilityZone($ec2Zone);
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return $this->server->getServices();
    }

    /**
     * {@inheritdoc}
     */
    public function setServices($services)
    {
        $this->server->setServices($services);
    }
}
