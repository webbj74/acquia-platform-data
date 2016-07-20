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

trait DbBackupDecoratorMethods
{
    /**
     * @var DbBackupInterface
     */
    protected $dbBackup;

    /**
     * Returns the decorated dbBackup instance.
     *
     * @return DbBackupInterface the decorated DbBackup
     */
    public function getDbBackup()
    {
        return $this->dbBackup;
    }

    /**
     * Sets the dbBackup instance being decorated.
     *
     * @param DbBackupInterface $dbBackup the DbBackup to decorate
     */
    public function setDbBackup(DbBackupInterface $dbBackup)
    {
        $this->dbBackup = $dbBackup;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->dbBackup->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->dbBackup->getType();
    }

    /**
     * {@inheritdoc}
     */
    public function setType($name)
    {
        $this->dbBackup->setType($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->dbBackup->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->dbBackup->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getLink()
    {
        return $this->dbBackup->getLink();
    }

    /**
     * {@inheritdoc}
     */
    public function setLink($link)
    {
        $this->dbBackup->setLink($link);
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->dbBackup->getPath();
    }

    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->dbBackup->setPath($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getStarted()
    {
        return $this->dbBackup->getStarted();
    }

    /**
     * {@inheritdoc}
     */
    public function setStarted($started)
    {
        $this->dbBackup->setStarted($started);
    }

    /**
     * {@inheritdoc}
     */
    public function getCompleted()
    {
        return $this->dbBackup->getCompleted();
    }

    /**
     * {@inheritdoc}
     */
    public function setCompleted($completed)
    {
        $this->dbBackup->setCompleted($completed);
    }

    /**
     * {@inheritdoc}
     */
    public function getDeleted()
    {
        return $this->dbBackup->getDeleted();
    }

    /**
     * {@inheritdoc}
     */
    public function setDeleted($deleted)
    {
        $this->dbBackup->setDeleted($deleted);
    }

    /**
     * {@inheritdoc}
     */
    public function getChecksum()
    {
        return $this->dbBackup->getChecksum();
    }

    /**
     * {@inheritdoc}
     */
    public function setChecksum($checksum)
    {
        $this->dbBackup->setChecksum($checksum);
    }
}
