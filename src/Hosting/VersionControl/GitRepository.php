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

class GitRepository extends Repository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCheckoutCommand($destination = '')
    {
        $checkoutCommand = "git clone {$this->repoUrl} {$destination}";
        if ($this->revision) {
            $gitDir = $this->applicationName;
            if (!empty($destination)) {
                $gitDir = $destination;
            }
            $gitPath = sprintf(
                "--git-dir=./%s/.git --work-tree=./%s",
                $gitDir,
                $gitDir
            );
            $checkoutCommand = sprintf(
                "git clone %s %s && git %s checkout %s",
                $this->repoUrl,
                $destination,
                $gitPath,
                $this->revision
            );
            if (!preg_match('|^tags/|', $this->revision)) {
                $checkoutCommand = sprintf(
                    "git clone -b %s %s %s",
                    $this->revision,
                    $this->repoUrl,
                    $destination
                );
            }
        }

        return $checkoutCommand;
    }

    /**
     * {@inheritdoc}
     */
    public function getBranchListCommand()
    {
        return "git ls-remote --heads {$this->repoUrl}";
    }

    /**
     * {@inheritdoc}
     */
    public function getTagListCommand()
    {
        return "git ls-remote --tags {$this->repoUrl}";
    }

    /**
     * {@inheritdoc}
     */
    public function getHistoryCommand($limit = 10)
    {
        return "git log -{$limit}";
    }
}
