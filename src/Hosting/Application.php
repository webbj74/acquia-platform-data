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

use Acquia\Platform\Cloud\Hosting\Environment\EnvironmentListInterface;
use Acquia\Platform\Cloud\Hosting\Monitor\Monitorable;
use InvalidArgumentException;
use RuntimeException;

final class Application implements ApplicationInterface
{
    use Monitorable;

    /**
     * @var EnvironmentListInterface
     */
    private $environmentList;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $productionMode;

    /**
     * @var RealmInterface
     */
    private $realm;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $unixUsername;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $vcsType;

    /**
     * @var string
     */
    private $vcsUrl;

    public function __construct($name)
    {
        if (!is_string($name) || !preg_match('#^[a-z0-9_-]+$#i', $name)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s: Application name must be an alphanumeric string (%s given)',
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
    public static function create(array $applicationData)
    {
        $app = new static($applicationData['name']);
        if (isset($applicationData['production_mode']) && is_numeric($applicationData['production_mode'])) {
            $app->setProductionMode((bool)$applicationData['production_mode']);
        }

        $propertySetters = [
            'realm' => 'setRealm',
            'environments' => 'setEnvironmentList',
            'title' => 'setTitle',
            'unix_username' => 'setUnixUsername',
            'uuid' => 'setUUID',
            'vcs_type' => 'setVcsType',
            'vcs_url' => 'setVcsRepositoryUrl',
        ];
        foreach ($propertySetters as $property => $setter) {
            if (isset($applicationData[$property]) && method_exists($app, $setter)) {
                call_user_func([$app, $setter], $applicationData[$property]);
            }
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
    public function getRealmQualifiedName()
    {
        return sprintf('%s:%s', $this->getRealm()->getName(), $this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        if ($this->title === null) {
            throw new RuntimeException(
                sprintf('%s: This Application object does not know the title.', __METHOD__)
            );
        }
        return $this->title;
    }

    /**
     * Add a string.
     *
     * @param array $title A string.
     */
    public function setTitle($title)
    {
        if (!is_string($title) || empty($title)) {
            throw new InvalidArgumentException(
                sprintf('%s: $title expects a string.', __METHOD__)
            );
        }
        $this->title = $title;
    }

    /**
     * {@inheritdoc}
     */
    public function getUUID()
    {
        if ($this->uuid === null) {
            throw new RuntimeException(
                sprintf('%s: This Application object does not know the UUID.', __METHOD__)
            );
        }
        return $this->uuid;
    }

    /**
     * Add a string.
     *
     * @param array $uuid A string.
     */
    public function setUUID($uuid)
    {
        if (!is_string($uuid)) {
            throw new InvalidArgumentException(
                sprintf('%s: $uuid expects a string.', __METHOD__)
            );
        }
        $this->uuid = empty($uuid) ? null : $uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function getVcsType()
    {
        if ($this->vcsType === null) {
            throw new RuntimeException(
                sprintf('%s: This Application object does not know the VCS type.', __METHOD__)
            );
        }
        return $this->vcsType;
    }

    /**
     * Add a string.
     *
     * @param array $vcsType A string.
     */
    public function setVcsType($vcsType)
    {
        if (!is_string($vcsType) || empty($vcsType)) {
            throw new InvalidArgumentException(
                sprintf('%s: $vcsType expects a string.', __METHOD__)
            );
        }
        $this->vcsType = $vcsType;
    }

    /**
     * {@inheritdoc}
     */
    public function getVcsRepositoryUrl()
    {
        if ($this->vcsUrl === null) {
            throw new RuntimeException(
                sprintf('%s: This Application object does not know the VCS URL.', __METHOD__)
            );
        }
        return $this->vcsUrl;
    }

    /**
     * Add a string.
     *
     * @param array $vcsUrl A string.
     */
    public function setVcsRepositoryUrl($vcsUrl)
    {
        if (!is_string($vcsUrl) || empty($vcsUrl)) {
            throw new InvalidArgumentException(
                sprintf('%s: $vcsUrl expects a string.', __METHOD__)
            );
        }
        $this->vcsUrl = $vcsUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function isInProduction()
    {
        if ($this->productionMode === null) {
            throw new RuntimeException(
                sprintf('%s: This Application object does not know the production mode.', __METHOD__)
            );
        }
        return $this->productionMode;
    }

    /**
     * Add a string.
     *
     * @param bool $productionMode A string.
     */
    public function setProductionMode($productionMode)
    {
        if (!is_bool($productionMode)) {
            throw new InvalidArgumentException(
                sprintf('%s: $productionMode expects a boolean.', __METHOD__)
            );
        }
        $this->productionMode = $productionMode;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnixUsername()
    {
        if ($this->unixUsername === null) {
            throw new RuntimeException(
                sprintf('%s: This Application object does not know the unix username.', __METHOD__)
            );
        }
        return $this->unixUsername;
    }

    /**
     * Add a string.
     *
     * @param array $unixUsername A string.
     */
    public function setUnixUsername($unixUsername)
    {
        if (!is_string($unixUsername) || empty($unixUsername)) {
            throw new InvalidArgumentException(
                sprintf('%s: $unixUsername expects a string.', __METHOD__)
            );
        }
        $this->unixUsername = $unixUsername;
    }

    /**
     * {@inheritdoc}
     */
    public function getRealm()
    {
        if ($this->realm === null) {
            throw new RuntimeException(
                sprintf('%s: This Application object does not know the realm.', __METHOD__)
            );
        }
        return $this->realm;
    }

    /**
     * Add a string.
     *
     * @param RealmInterface $realm The realm this application is hosted in.
     */
    public function setRealm(RealmInterface $realm)
    {
        $this->realm = $realm;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironmentList()
    {
        if ($this->environmentList === null) {
            throw new RuntimeException(
                sprintf('%s: This Application object does not know the environment list.', __METHOD__)
            );
        }
        return $this->environmentList;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnvironmentList(EnvironmentListInterface $environmentList)
    {
        $this->environmentList = $environmentList;
    }
}
