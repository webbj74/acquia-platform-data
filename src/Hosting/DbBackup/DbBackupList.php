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

use Acquia\Platform\Cloud\Hosting\DbBackupInterface;
use ArrayObject;
use InvalidArgumentException;

class DbBackupList extends ArrayObject implements DbBackupListInterface
{
    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Overrides ArrayObject::offsetSet() to validate that the value set at the
     * specified offset is a DbBackup.
     *
     * No value is returned.
     *
     * @param mixed             $offset
     * @param DbBackupInterface $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_subclass_of($value, 'Acquia\Platform\Cloud\Hosting\DbBackupInterface')) {
            throw new InvalidArgumentException(
                sprintf('%s: $value must be an implementation of DbBackupInterface', __METHOD__)
            );
        }
        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function filterById($backupIds)
    {
        if (!is_array($backupIds)) {
            throw new InvalidArgumentException(
                sprintf('%s: $backupIds must be an array', __METHOD__)
            );
        }

        $dbBackupSubset = new static();
        $listIterator = $this->getIterator();
        while ($listIterator->valid()) {
            if (in_array($listIterator->current()->getId(), $backupIds)) {
                $dbBackupSubset->append($listIterator->current());
            }
            $listIterator->next();
        }

        return $dbBackupSubset;
    }
}
