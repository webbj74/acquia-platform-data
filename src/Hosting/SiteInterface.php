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
 * A Hosting Site corresponds to a "child subscription" or "sitegroup" or a
 * cloud api "site". It refers to an application independent of its
 * environment-based deployments. A Site
 * - Contain specific entitlements that are different than the subscription
 * - Inherit entitlements from the subscription if they are not overridden
 * - Contain one or more environments
 * - Contain 1 VCS repo (GIT or SVN)
 * - Belongs to a Realm
 */
interface SiteInterface
{
    /**
     * Returns the machine-name of the site. Examples:
     * - mysite
     * - examplecom
     *
     * @return string The machine-name of the site.
     */
    public function getName();

    /**
     * Returns the realm-qualified name. For example:
     * - prod:mysite.
     * - devcloud:examplecom
     *
     * @return string
     */
    public function getRealmQualifiedName();

    /**
     * Returns the version control system used by the site. Examples:
     * - svn
     * - git
     *
     * @return string The version control system used by the site.
     */
    public function getVcsType();

    /**
     * Set the version control system used by the site.
     *
     * @param array $vcsType The version control system used by the site.
     */
    public function setVcsType($vcsType);

    /**
     * Returns the VCS Repository URL used by the site. Examples:
     * - https://vcs-123.prod.hosting.acquia.com/mysite
     * - examplecom@vcs-456.devcloud.hosting.acquia.com:examplecom.git
     *
     * @return string The VCS Repository URL used by the site.
     */
    public function getVcsRepositoryUrl();

    /**
     * Sets the repository URL for this site.
     *
     * @param array $vcsUrl The VCS Repository URL used by the site.
     */
    public function setVcsRepositoryUrl($vcsUrl);

    /**
     * Indicates whether the application is in production mode. This affects
     * the ability to overwrite production database from a lower environment.
     * - true
     * - false
     *
     * @return boolean Returns true if the site is in production mode; false
     *                 otherwise.
     */
    public function isInProduction();

    /**
     * Indicate if the site is in production mode.
     *
     * @param bool $productionMode A string.
     */
    public function setProductionMode($productionMode);

    /**
     * Returns the unix username related to the site. Usually this is the same
     * as the application name. Examples:
     * - mysite
     * - examplecom
     *
     * Note: when connecting to a server deployed to a specific environment,
     *
     * @return string The base unix username related to the site.
     */
    public function getUnixUsername();

    /**
     * Set the unix username for the site.
     *
     * @param array $unixUsername The base unix username.
     */
    public function setUnixUsername($unixUsername);

    /**
     * Returns the sites's short, human-readable description. For example:
     * - My Very First Acquia Site
     * - example.com - D7 Rebuild
     *
     * @return array A short, human-readable description of the Site.
     */
    public function getTitle();

    /**
     * Set the short, human-readable description of the Site.
     *
     * @param array $title A short, human-readable description of the Site.
     */
    public function setTitle($title);

    /**
     * Returns the UUID of the site. Examples:
     * - 0e88acab-0123-feeb-daed-45bccbd68888
     * - 45bcfeeb-acab-0123-8888-daedcbd6d8eb
     *
     * @return string The UUID of the site.
     */
    public function getUUID();

    /**
     * Set the UUID of the site.
     *
     * @param array $uuid The UUID of the site.
     */
    public function setUUID($uuid);

    /**
     * Returns the realm object this site is hosted in.
     *
     * @return RealmInterface The realm this site is hosted in.
     */
    public function getRealm();

    /**
     * Set the Realm object representing the realm this site is hosted in.
     *
     * @param RealmInterface $realm The realm this site is hosted in.
     */
    public function setRealm(RealmInterface $realm);
}
