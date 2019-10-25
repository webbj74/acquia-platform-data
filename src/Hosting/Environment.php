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

use Acquia\Platform\Cloud\Hosting\Environment\EnvironmentFactory;
use Acquia\Platform\Cloud\Hosting\Monitor\Monitorable;
use Acquia\Platform\Cloud\Hosting\Server\ServerListInterface;
use InvalidArgumentException;
use RuntimeException;

final class Environment implements EnvironmentInterface
{
    use Monitorable;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $revision;

    /**
     * @var string
     */
    private $defaultHostName;

    /**
     * @var array
     */
    private $databaseClusterList;

    /**
     * @var string
     */
    private $defaultDomainName;

    /**
     * @var boolean
     */
    private $inLiveDevelopment;

    /**
     * @var string
     */
    private $unixUserName;

    /**
     * @var string
     */
    private $machineName;

    /**
     * @var ServerListInterface
     */
    private $serverList;

    public function __construct($name)
    {
        if (!is_string($name) || !preg_match('#^[a-z0-9-_]+$#i', $name)) {
            throw new InvalidArgumentException(
                sprintf('%s: Environment name must be an alphanumeric string (%s)', __METHOD__, $name)
            );
        }
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public static function create(array $environmentData)
    {
        return EnvironmentFactory::getEnvironmentFromCloudApiData($environmentData);
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
    public function getRevision()
    {
        if ($this->revision === null) {
            throw new RuntimeException(
                sprintf('%s: This Environment object does not know its VCS revision.', __METHOD__)
            );
        }
        return $this->revision;
    }

    /**
     * {@inheritdoc}
     */
    public function setRevision($revision)
    {
        if (!is_string($revision) || empty($revision)) {
            throw new InvalidArgumentException(
                sprintf('%s: $revision expects a string.', __METHOD__)
            );
        }
        $this->revision = $revision;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultHostName()
    {
        if ($this->defaultHostName === null) {
            throw new RuntimeException(
                sprintf('%s: This Environment object does not know its default host name.', __METHOD__)
            );
        }
        return $this->defaultHostName;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultHostName($defaultHostName)
    {
        if (!is_string($defaultHostName) || empty($defaultHostName)) {
            throw new InvalidArgumentException(
                sprintf('%s: $defaultHostName expects a string.', __METHOD__)
            );
        }
        $this->defaultHostName = $defaultHostName;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabaseClusterList()
    {
        if ($this->databaseClusterList === null) {
            throw new RuntimeException(
                sprintf('%s: This Environment object does not know its database cluster list.', __METHOD__)
            );
        }
        return $this->databaseClusterList;
    }

    /**
     * {@inheritdoc}
     */
    public function setDatabaseClusterList(array $databaseClusterList)
    {
        $this->databaseClusterList = $databaseClusterList;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDomainName()
    {
        if ($this->defaultDomainName === null) {
            throw new RuntimeException(
                sprintf('%s: This Environment object does not know its default domain name.', __METHOD__)
            );
        }
        return $this->defaultDomainName;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultDomainName($defaultDomainName)
    {
        if (!is_string($defaultDomainName) || empty($defaultDomainName)) {
            throw new InvalidArgumentException(
                sprintf('%s: $defaultDomainName expects a string.', __METHOD__)
            );
        }
        $this->defaultDomainName = $defaultDomainName;
    }

    /**
     * {@inheritdoc}
     */
    public function isInLiveDev()
    {
        if ($this->inLiveDevelopment === null) {
            throw new RuntimeException(
                sprintf('%s: This Environment object does not know if the application is in Live Dev mode.', __METHOD__)
            );
        }
        return $this->inLiveDevelopment;
    }

    /**
     * {@inheritdoc}
     */
    public function setInLiveDev($inLiveDevelopment)
    {
        if (!is_bool($inLiveDevelopment)) {
            throw new InvalidArgumentException(
                sprintf('%s: $inLiveDevelopment expects a boolean value.', __METHOD__)
            );
        }
        $this->inLiveDevelopment = $inLiveDevelopment;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnixUserName()
    {
        if ($this->unixUserName === null) {
            throw new RuntimeException(
                sprintf('%s: This Environment object does not know its UNIX user name.', __METHOD__)
            );
        }
        return $this->unixUserName;
    }

    /**
     * {@inheritdoc}
     */
    public function setUnixUserName($unixUserName)
    {
        if (!is_string($unixUserName) || empty($unixUserName)) {
            throw new InvalidArgumentException(
                sprintf('%s: $unixUserName expects a string.', __METHOD__)
            );
        }
        $this->unixUserName = $unixUserName;
    }

    /**
     * {@inheritdoc}
     */
    public function getMachineName()
    {
        if ($this->machineName === null) {
            throw new RuntimeException(
                sprintf('%s: This Environment object does not know its machine name.', __METHOD__)
            );
        }
        return $this->machineName;
    }

    /**
     * {@inheritdoc}
     */
    public function setMachineName($machineName)
    {
        if (!is_string($machineName) || empty($machineName)) {
            throw new InvalidArgumentException(
                sprintf('%s: $machineName expects a string.', __METHOD__)
            );
        }
        $this->machineName = $machineName;
    }

    /**
     * {@inheritdoc}
     */
    public function setServerList(ServerListInterface $serverList)
    {
        $this->serverList = $serverList;
    }

    /**
     * {@inheritdoc}
     */
    public function getServerList()
    {
        if ($this->serverList === null) {
            throw new RuntimeException(
                sprintf(
                    '%s: This object does not know which servers are assigned to the environment.',
                    __METHOD__
                )
            );
        }
        return $this->serverList;
    }

    /**
     * {@inheritdoc}
     */
    public function getApplicationQualifiedName()
    {
        /*
         * Considering data from Cloud API, Unix Username provides the same result.
         */
        return $this->getUnixUserName();
    }

    /**
     * {@inheritdoc}
     */
    public function getDocumentRootPath()
    {
        /**
         * @var string $appQualifiedName
         */
        $appQualifiedName = $this->getApplicationQualifiedName();
        
        /**
         * @var string $documentRootPath
         */
        $documentRootPath = sprintf('/var/www/html/%s/docroot', $appQualifiedName);

        if ($this->isInLiveDev()) {
            $documentRootPath = sprintf('/mnt/gfs/%s/livedev/docroot', $appQualifiedName);
        }

        return $documentRootPath;
    }
}
