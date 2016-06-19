<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Environment;

use Acquia\Platform\Cloud\Hosting\Environment;

class EnvironmentFactory
{
    public static function getEnvironmentFromCloudApiData($environmentData)
    {
        $environment = new Environment($environmentData['name']);
        if (isset($environmentData['vcs_path'])) {
            $environment->setRevision($environmentData['vcs_path']);
        }
        if (isset($environmentData['ssh_host'])) {
            $environment->setDefaultHostName($environmentData['ssh_host']);
        }
        if (isset($environmentData['db_clusters'])) {
            $environment->setDatabaseClusterList($environmentData['db_clusters']);
        }
        if (isset($environmentData['default_domain']) && !empty($environmentData['default_domain'])) {
            $environment->setDefaultDomainName($environmentData['default_domain']);
            $nameParts = explode('.', $environmentData['default_domain']);
            $environment->setMachineName($nameParts[0]);
        }
        if (isset($environmentData['livedev'])) {
            $environment->setInLiveDev(($environmentData['livedev'] != 'disabled'));
        }
        if (isset($environmentData['unix_username'])) {
            $environment->setUnixUserName($environmentData['unix_username']);
        }

        return $environment;
    }
}
