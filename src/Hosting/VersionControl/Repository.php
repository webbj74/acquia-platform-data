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
use Acquia\Platform\Cloud\Hosting\EnvironmentInterface;

abstract class Repository
{
    protected $applicationName;
    protected $repoUrl;
    protected $revision;
    protected $siteName;

    /**
     * Repository constructor.
     *
     * @param ApplicationInterface $application
     * @param EnvironmentInterface|null $environment
     */
    public function __construct(
        ApplicationInterface $application,
        $environment
    ) {
        $this->applicationName = $application->getName();
        $this->repoUrl = $application->getVcsRepositoryUrl();
        if ($environment !== null) {
            $this->siteName = $environment->getMachineName();
            $this->revision = $environment->getRevision();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->repoUrl;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getHistoryCommand($limit);

    /**
     * {@inheritdoc}
     */
    public function formatRevisionString()
    {
        return "{$this->repoUrl}  {$this->revision}";
    }
}
