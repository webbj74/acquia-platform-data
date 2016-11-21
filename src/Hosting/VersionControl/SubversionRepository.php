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

class SubversionRepository extends Repository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCheckoutCommand($destination = '')
    {
        $checkoutCommand = "svn checkout {$this->repoUrl}/trunk {$destination}";
        if ($this->revision) {
            $checkoutCommand = "svn checkout {$this->repoUrl}/{$this->revision} {$destination}";
        }
        return $checkoutCommand;
    }

    /**
     * {@inheritdoc}
     */
    public function getBranchListCommand()
    {
        return "svn list {$this->repoUrl}/branches";
    }

    /**
     * {@inheritdoc}
     */
    public function getTagListCommand()
    {
        return "svn list {$this->repoUrl}/tags";
    }

    /**
     * {@inheritdoc}
     */
    public function getHistoryCommand($limit = 10)
    {
        return "svn log --limit {$limit}";
    }

    /**
     * {@inheritdoc}
     */
    public function formatRevisionString()
    {
        return "{$this->repoUrl}/{$this->revision}";
    }
}
