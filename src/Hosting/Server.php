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

final class Server implements ServerInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $fullyQualifiedDomainName;

    /**
     * @var string
     */
    private $amiType;

    /**
     * @var string
     */
    private $ec2Region;

    /**
     * @var string
     */
    private $ec2AvailabilityZone;

    /**
     * @var array
     */
    private $services;

    public function __construct($name)
    {
        if (!is_string($name) || !preg_match('#^[a-z0-9-]+$#i', $name)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s: Server name must be an alphanumeric string (%s given)',
                    __METHOD__,
                    is_string($name) ? $name : gettype($name)
                )
            );
        }
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(array $serverData)
    {
        $app = new static($serverData['name']);
        if (isset($serverData['fully_qualified_domain_name'])) {
            $app->setFullyQualifiedDomainName($serverData['fully_qualified_domain_name']);
        }
        if (isset($serverData['ami_type'])) {
            $app->setAmiType($serverData['ami_type']);
        }
        if (isset($serverData['ec2_region'])) {
            $app->setAmiType($serverData['ec2_region']);
        }
        if (isset($serverData['ec2_availability_zone'])) {
            $app->setAmiType($serverData['ec2_availability_zone']);
        }
        if (isset($serverData['services']) && is_array($serverData['services'])) {
            $app->setServices($serverData['services']);
        }

        return $app;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullyQualifiedDomainName()
    {
        if ($this->fullyQualifiedDomainName === null) {
            throw new \RuntimeException(
              sprintf('%s: This Server object does not know the Fully Qualified Domain Name.', __METHOD__)
            );
        }
        return $this->fullyQualifiedDomainName;
    }

    /**
     * Add a string.
     *
     * @param string $fullyQualifiedDomainName A string.
     */
    public function setFullyQualifiedDomainName($fullyQualifiedDomainName)
    {
        if (!is_string($fullyQualifiedDomainName) || empty($fullyQualifiedDomainName)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $fullyQualifiedDomainName expects a string.', __METHOD__)
            );
        }
        $this->fullyQualifiedDomainName = $fullyQualifiedDomainName;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmiType()
    {
        if ($this->amiType === null) {
            throw new \RuntimeException(
                sprintf('%s: This Server object does not know the AMI Type.', __METHOD__)
            );
        }
        return $this->amiType;
    }

    /**
     * Add a string.
     *
     * @param string $amiType A string.
     */
    public function setAmiType($amiType)
    {
        if (!is_string($amiType) || empty($amiType)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $amiType expects a string.', __METHOD__)
            );
        }
        $this->amiType = $amiType;
    }

    /**
     * {@inheritdoc}
     */
    public function getEc2Region()
    {
        if ($this->ec2Region === null) {
            throw new \RuntimeException(
              sprintf('%s: This Server object does not know the EC2 Region.', __METHOD__)
            );
        }
        return $this->ec2Region;
    }

    /**
     * Add a string.
     *
     * @param string $ec2Region A string.
     */
    public function setEc2Region($ec2Region)
    {
        if (!is_string($ec2Region) || empty($ec2Region)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $ec2Region expects a string.', __METHOD__)
            );
        }
        $this->ec2Region = $ec2Region;
    }

    /**
     * {@inheritdoc}
     */
    public function getEc2AvailabilityZone()
    {
        if ($this->ec2AvailabilityZone === null) {
            throw new \RuntimeException(
              sprintf('%s: This Server object does not know the EC2 Availability Zone.', __METHOD__)
            );
        }
        return $this->ec2AvailabilityZone;
    }

    /**
     * Add a string.
     *
     * @param string $ec2AvailabilityZone A string.
     */
    public function setEc2AvailabilityZone($ec2AvailabilityZone)
    {
        if (!is_string($ec2AvailabilityZone) || empty($ec2AvailabilityZone)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $ec2AvailabilityZone expects a string.', __METHOD__)
            );
        }
        $this->ec2AvailabilityZone = $ec2AvailabilityZone;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        if ($this->services === null) {
            throw new \RuntimeException(
              sprintf('%s: This Server object does not know the services array.', __METHOD__)
            );
        }
        return $this->services;
    }

    /**
     * Add an array.
     *
     * @param array $services An array.
     */
    public function setServices($services)
    {
        if (!is_array($services) || empty($services)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $services expects an array.', __METHOD__)
            );
        }
        $this->services = $services;
    }
}
