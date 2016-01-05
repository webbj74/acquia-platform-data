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
 * A Server corresponds to actual hardware used on our hosting. It contains:
 * - Short name of the server, eg. staging-1234
 * - Fully qualified domain name, eg. staging-1234.prod.hosting.acquia.com
 * - Amazon instance type, eg. m2.xlarge
 * - EC2 Region, eg. us-east-1
 * - EC2 availability zone, eg us-east-1d
 */
interface ServerInterface
{
    /**
     * Factory method for Server classes.
     *
     * @param array $serverData
     *
     * @return ServerInterface
     */
    public static function create(array $serverData);

    /**
     * Returns the machine-name of the server. For example:
     * - staging-1234
     * - web-123
     *
     * @return string The machine-name of the server.
     */
    public function getName();

    /**
     * Returns the fully qualified domain name. For example:
     * - staging-1234.prod.hosting.acquia.com
     * - web-1234.prod.hosting.acquia.com
     *
     * @return string The Fully Qualified Domain name.
     */
    public function getFullyQualifiedDomainName();

    /**
     * Returns the Amazon Instance type for the server.
     * @see http://www.ec2instances.info/
     * For example:
     * - m2.xlarge
     * - c1.medium
     *
     * @return string The Amazon Instance Type.
     */
    public function getAmiType();

    /**
     * Sets the Amazon Instance type for the server.
     * @param string $amiType Amazon Instance type for the server.
     */
    public function setAmiType($amiType);

    /**
     * Returns the EC2 Region for the server.
     * @see https://aws.amazon.com/about-aws/global-infrastructure/
     * For example:
     * - us-east-1
     * @return string EC2 Region for the server.
     */
    public function getEc2Region();

    /**
     * Sets the EC2 Region for the server.
     * @param string $ec2Region EC2 Region type for the server.
     */
    public function setEc2Region($ec2Region);

    /**
     * Returns the EC2 Availability Zone for the server
     * @see https://aws.amazon.com/about-aws/global-infrastructure/
     * For Example:
     *  - us-east-1d
     * @return string EC2 Availability Zone.
     */
    public function getEc2AvailabilityZone();

    /**
     * Sets the EC2 Availability zone for the server.
     * @param string $availZone EC2 Availability zone for the server.
     */
    public function setEc2AvailabilityZone($availZone);

    /**
     * Get the services information associated with the server.
     * @return array Services associated with the server.
     */
    public function getServices();

    /**
     * Set the services information associated with the server.
     * @param array $services An array of services.
     */
    public function setServices($services);
}
