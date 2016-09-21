<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting;

/**
 * A DbBackup corresponds to a backup of a database for a client's application.
 * It contains:
 * - A backup ID eg. 12345678
 * - A backup type, eg. daily, or ondemand
 * - A name, eg. mysite
 * - A link, eg. https://www.acquia.com/
 * - A path, eg. backups/user-prod-db-backup.sql.gz
 * - A started timestamp, eg. 1468218381
 * - A completed timestamp, eg. 1468219381
 * - A deleted marker, eg. 0 or 1
 * - A checksum, eg. a9e3dac5c312f49415b613aff078f5dd
 */
interface DbBackupInterface
{
    /**
     * Factory method for DbBackup classes.
     *
     * @param array $dbBackupData
     *
     * @return DbBackupInterface
     */
    public static function create(array $dbBackupData);

    /**
     * Returns the ID of the dbbackup.
     *
     * @return int The ID of the dbbackup.
     */
    public function getId();

    /**
     * Returns the type of the database backup.
     *
     * @return string The type of the database backup.
     */
    public function getType();
    
    /**
     * Sets the type of the dbbackup.
     *
     * @param string $type The type of the dbbackup.
     */
    public function setType($type);

    /**
     * Returns the name for the database backup.
     *
     * @return int The name for the database backup.
     */
    public function getName();
    
    /**
     * Sets the name of the dbbackup.
     *
     * @param int $siteId The name of the dbbackup.
     */
    public function setName($siteId);

    /**
     * Returns the Link for the database backup.
     *
     * @return int The Link for the database backup.
     */
    public function getLink();
    
    /**
     * Sets the Link of the dbbackup.
     *
     * @param int $dbId The Link of the dbbackup.
     */
    public function setLink($dbId);

    /**
     * Returns the path for the database backup.
     *
     * @return string|null The path for the database backup.
     */
    public function getPath();
    
    /**
     * Sets the path of the dbbackup.
     *
     * @param string|null $path The path of the dbbackup.
     */
    public function setPath($path);

    /**
     * Returns the started timestamp for the database backup.
     *
     * @return int The started timestamp for the database backup.
     */
    public function getStarted();
    
    /**
     * Sets the started timestamp of the dbbackup.
     *
     * @param int $started The started timestamp of the dbbackup.
     */
    public function setStarted($started);

    /**
     * Returns the completed timestamp for the database backup.
     *
     * @return int The completed timestamp for the database backup.
     */
    public function getCompleted();
    
    /**
     * Sets the completed timestamp of the dbbackup.
     *
     * @param int $completed The completed timestamp of the dbbackup.
     */
    public function setCompleted($completed);

    /**
     * Returns whether or not the database backup has been deleted.
     *
     * @return int whether or not the database backup has been deleted.
     */
    public function getDeleted();
    
    /**
     * Sets the deleted value of the dbbackup.
     *
     * @param int $deleted The deleted value of the dbbackup.
     */
    public function setDeleted($deleted);

    /**
     * Returns the checksum for the database backup.
     *
     * @return string The checksum for the database backup.
     */
    public function getChecksum();
    
    /**
     * Sets the checksum of the dbbackup.
     *
     * @param string $checksum The checksum of the dbbackup.
     */
    public function setChecksum($checksum);
}
