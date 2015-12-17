<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Realm;

use Acquia\Platform\Cloud\Hosting\Realm;
use Acquia\Platform\Cloud\Hosting\RealmInterface;

trait RealmDecoratorMethods
{
    /**
     * @var RealmInterface
     */
    protected $realm;

    /**
     * Returns the decorated Realm instance.
     *
     * @return RealmInterface the decorated Realm
     */
    public function getRealm()
    {
        return $this->realm;
    }

    /**
     * Sets the Realm instance being decorated.
     *
     * @param RealmInterface $realm the Realm to decorate
     */
    public function setRealm(RealmInterface $realm)
    {
        $this->realm = $realm;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->realm->__toString();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->realm->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getHostNameRoot()
    {
        return $this->realm->getHostNameRoot();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSiteDomainNameRoot()
    {
        return $this->realm->getDefaultSiteDomainNameRoot();
    }

    /**
     * {@inheritdoc}
     */
    public function setDefault($isDefault)
    {
        $this->realm->setDefault($isDefault);
    }

    /**
     * {@inheritdoc}
     */
    public function isDefault()
    {
        return $this->realm->isDefault();
    }
}
