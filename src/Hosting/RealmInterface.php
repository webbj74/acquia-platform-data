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
 * In Acquia Platform a "realm" is a subdivision of Acquia Cloud sites, servers
 * and domains. Historically realms have also been referred to as Network Stage.
 * Examples of realms are:
 * - prod (Acquia Cloud Enterprise)
 * - devcloud (Acquia Cloud Professional & Free Tier)
 */
interface RealmInterface
{
    const DOMAIN_NAME_ROOT = 'acquia-sites.com';
    const HOST_NAME_ROOT = 'hosting.acquia.com';

    /**
     * Factory method for Realm classes.
     *
     * @param array $realmData
     *
     * @return RealmInterface
     */
    public static function create($realmData);

    /**
     * Returns a description of the realm. Minimally this will be the machine-
     * name of the realm. However decorator classes may embellish this.
     *
     * @return string A description of the realm.
     */
    public function __toString();

    /**
     * Returns the machine-name of the realm. Examples:
     * - prod
     * - devcloud
     *
     * @return string The machine-name of the realm.
     */
    public function getName();

    /**
     * Returns the DNS root for servers in the realm. Examples:
     * - prod.hosting.acquia.com
     * - devcloud.hosting.acquia.com
     *
     * @return string The DNS root for servers in the realm.
     */
    public function getHostNameRoot();

    /**
     * Returns the DNS root for site domains in the realm. Examples:
     * - prod.acquia-sites.com
     * - devcloud.acquia-sites.com
     *
     * @return string The DNS root for site domains in the realm.
     */
    public function getDefaultSiteDomainNameRoot();
}
