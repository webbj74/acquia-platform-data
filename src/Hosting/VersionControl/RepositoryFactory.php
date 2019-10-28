<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\VersionControl;

use Acquia\Platform\Cloud\Hosting\ApplicationInterface;
use RuntimeException;

class RepositoryFactory
{
    public static function getRepository(ApplicationInterface $application, $environment)
    {
        $repo = null;
        if (strstr($application->getVcsRepositoryUrl(), '.git') !== false) {
            $repo = new GitRepository($application, $environment);
        }
        if (strstr($application->getVcsRepositoryUrl(), 'https://svn') !== false) {
            $repo = new SubversionRepository($application, $environment);
        }
        if (!$repo) {
            throw new RuntimeException("Unsupported Version Control System");
        }
        return $repo;
    }
}
