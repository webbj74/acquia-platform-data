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

use InvalidArgumentException;

final class Realm implements RealmInterface
{
    /**
     * @var bool $isDefault - True if this realm is a default realm
     */
    private $isDefaultRealm = false;

    /**
     * @var string
     */
    private $name;

    public function __construct($name)
    {
        if (!is_string($name) || !preg_match('#^[a-z0-9-]+$#i', $name)) {
            throw new InvalidArgumentException(
                sprintf('%s: Realm name must be an alphanumeric string', __METHOD__)
            );
        }
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public static function create($realmData)
    {
        $realm = new static($realmData['name']);
        $realm->setDefault(isset($realmData['default']) ? $realmData['default'] : false);
        return $realm;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->name;
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
    public function getHostNameRoot()
    {
        return sprintf('%s.%s', $this->name, RealmInterface::HOST_NAME_ROOT);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSiteDomainNameRoot()
    {
        return sprintf('%s.%s', $this->name, RealmInterface::DOMAIN_NAME_ROOT);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefault($isDefault)
    {
        $this->isDefaultRealm = $isDefault;
    }

    /**
     * {@inheritdoc}
     */
    public function isDefault()
    {
        return $this->isDefaultRealm;
    }
}
