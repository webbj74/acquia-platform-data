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

interface RepositoryInterface
{
    /**
     * Return the repository URL.
     *
     * @return string The repository URL.
     */
    public function getUrl();

    /**
     * Return a command which can be used to checkout a branch on the repo.
     *
     * @param string $destination Optional destination folder.
     *
     * @return string A command.
     */
    public function getCheckoutCommand($destination = '');

    /**
     * Return a command to list branch names
     *
     * @return string A command.
     */
    public function getBranchListCommand();

   /**
     * Return a command to list tag names
     *
     * @return string A command.
     */
    public function getTagListCommand();

    /**
     * Returns a command for retrieving commit history from a repository.
     *
     * @return string A command.
     */
    public function getHistoryCommand($limit = 10);

    /**
     * Returns a string with the repo URL and revision together.
     *
     * @return string
     */
    public function formatRevisionString();
}
