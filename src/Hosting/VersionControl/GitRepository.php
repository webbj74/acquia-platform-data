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
            $revision = preg_replace('#^tags/#', '', $this->revision);
            $checkoutCommand = sprintf(
                "git clone -b %s %s %s",
                $revision,
                $this->repoUrl,
                $destination
            );
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
