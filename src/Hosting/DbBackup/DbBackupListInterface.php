<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\DbBackup;

interface DbBackupListInterface
{
    /**
     * Returns a subset of known database backups matching the provided backup ids
     *
     * @param array|int $backupIds An array of db backup ids.
     *
     * @return DbBackupListInterface
     */
    public function filterById($backupIds);
}
