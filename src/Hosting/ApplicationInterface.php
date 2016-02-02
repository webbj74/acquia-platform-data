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

/**
 * A Hosting Application corresponds to a "child subscription" or "sitegroup"
 * or a cloud api "site". It refers to a web application independent of its
 * environment-based deployments. An Application:
 * - Contains specific entitlements that are different than the subscription
 * - Inherit entitlements from the subscription if they are not overridden
 * - Contains one or more environments
 * - Contains 1 VCS repo (GIT or SVN)
 * - Belongs to a Realm
 */
interface ApplicationInterface
{
    /**
     * Factory method for Application classes.
     *
     * @param array $applicationData
     *
     * @return ApplicationInterface
     */
    public static function create(array $applicationData);

    /**
     * Returns the machine-name of the application. Examples:
     * - myapp
     * - examplecom
     *
     * @return string The machine-name of the application.
     */
    public function getName();

    /**
     * Returns the realm-qualified name. For example:
     * - prod:myapp.
     * - devcloud:examplecom
     *
     * @return string
     */
    public function getRealmQualifiedName();

    /**
     * Returns the version control system used by the application. Examples:
     * - svn
     * - git
     *
     * @return string The version control system used by the application.
     */
    public function getVcsType();

    /**
     * Set the version control system used by the application.
     *
     * @param array $vcsType The version control system used by the application.
     */
    public function setVcsType($vcsType);

    /**
     * Returns the VCS Repository URL used by the application. Examples:
     * - https://vcs-123.prod.hosting.acquia.com/myapp
     * - examplecom@vcs-456.devcloud.hosting.acquia.com:examplecom.git
     *
     * @return string The VCS Repository URL used by the application.
     */
    public function getVcsRepositoryUrl();

    /**
     * Sets the repository URL for this application.
     *
     * @param array $vcsUrl The VCS Repository URL used by the application.
     */
    public function setVcsRepositoryUrl($vcsUrl);

    /**
     * Indicates whether the application is in production mode. This affects
     * the ability to overwrite production database from a lower environment.
     * - true
     * - false
     *
     * @return boolean Returns true if the application is in production mode;
     *                 false otherwise.
     */
    public function isInProduction();

    /**
     * Indicate if the application is in production mode.
     *
     * @param bool $productionMode A string.
     */
    public function setProductionMode($productionMode);

    /**
     * Returns the unix username related to the application. Usually this is
     * the same as the application name. Examples:
     * - myapp
     * - examplecom
     *
     * Note: when connecting to a server deployed to a specific environment,
     *
     * @return string The base unix username related to the application.
     */
    public function getUnixUsername();

    /**
     * Set the unix username for the application.
     *
     * @param array $unixUsername The base unix username.
     */
    public function setUnixUsername($unixUsername);

    /**
     * Returns the applications's short, human-readable description. For
     * example:
     * - My Very First Acquia Application
     * - example.com - D7 Rebuild
     *
     * @return array A short, human-readable description of the application.
     */
    public function getTitle();

    /**
     * Set the short, human-readable description of the application.
     *
     * @param array $title A short, human-readable description of the application.
     */
    public function setTitle($title);

    /**
     * Returns the UUID of the application. Examples:
     * - 0e88acab-0123-feeb-daed-45bccbd68888
     * - 45bcfeeb-acab-0123-8888-daedcbd6d8eb
     *
     * @return string The UUID of the application.
     */
    public function getUUID();

    /**
     * Set the UUID of the application.
     *
     * @param array $uuid The UUID of the application.
     */
    public function setUUID($uuid);

    /**
     * Returns the realm object this application is hosted in.
     *
     * @return RealmInterface The realm this application is hosted in.
     */
    public function getRealm();

    /**
     * Set the Realm object representing the realm this application is hosted in.
     *
     * @param RealmInterface $realm The realm this application is hosted in.
     */
    public function setRealm(RealmInterface $realm);

    /**
     * Return the list of environments that belong to this application.
     *
     * @return EnvironmentListInterface
     */
    public function getEnvironmentList();

    /**
     * Set the list of environments that belong to this application.
     *
     * @param EnvironmentListInterface $environmentList
     *   The environments that belong to this application.
     */
    public function setEnvironmentList(EnvironmentListInterface $environmentList);
}
