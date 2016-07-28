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

final class DbBackup implements DbBackupInterface
{
    /**
     * @var int
     */
    private $backupId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $started;

    /**
     * @var int
     */
    private $completed;

    /**
     * @var bool
     */
    private $deleted;

    /**
     * @var string
     */
    private $checksum;

    public function __construct($backupId)
    {
        if (!is_numeric($backupId)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s: DbBackup ID must be a numeric value (%s given)',
                    __METHOD__,
                    gettype($backupId)
                )
            );
        }
        $this->backupId = $backupId;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(array $dbBackupData)
    {
        $dbBackup = new static($dbBackupData['id']);

        $propertySetters = [
            'type' => 'setType',
            'name' => 'setName',
            'link' => 'setLink',
            'path' => 'setPath',
            'started' => 'setStarted',
            'completed' => 'setCompleted',
            'deleted' => 'setDeleted',
            'checksum' => 'setChecksum',
        ];

        foreach ($propertySetters as $property => $setter) {
            if (isset($dbBackupData[$property]) && method_exists($dbBackup, $setter)) {
                call_user_func([$dbBackup, $setter], $dbBackupData[$property]);
            }
        }

        return $dbBackup;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->backupId;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        if ($this->type === null) {
            throw new \RuntimeException(
                sprintf('%s: This DbBackup object does not know the type.', __METHOD__)
            );
        }
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        if (!is_string($type) || empty($type)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $type expects a string.', __METHOD__)
            );
        }
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        if ($this->name === null) {
            throw new \RuntimeException(
                sprintf('%s: This DbBackup object does not know the name.', __METHOD__)
            );
        }
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        if (!is_string($name) || empty($name)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $name expects a string.', __METHOD__)
            );
        }
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getLink()
    {
        if ($this->link === null) {
            throw new \RuntimeException(
                sprintf('%s: This DbBackup object does not know the link.', __METHOD__)
            );
        }
        return $this->link;
    }

    /**
     * {@inheritdoc}
     */
    public function setLink($link)
    {
        if (!is_string($link) || empty($link)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $link expects an string.', __METHOD__)
            );
        }
        $this->link = $link;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        if ($this->path === null) {
            throw new \RuntimeException(
                sprintf('%s: This DbBackup object does not know the path.', __METHOD__)
            );
        }
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        if (!is_string($path) || empty($path)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $path expects a string.', __METHOD__)
            );
        }
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getStarted()
    {
        if ($this->started === null) {
            throw new \RuntimeException(
                sprintf('%s: This DbBackup object does not know the started time.', __METHOD__)
            );
        }
        return $this->started;
    }

    /**
     * {@inheritdoc}
     */
    public function setStarted($started)
    {
        if (!is_numeric($started) || empty($started)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $started expects an int.', __METHOD__)
            );
        }
        $this->started = $started;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompleted()
    {
        if ($this->completed === null) {
            throw new \RuntimeException(
                sprintf('%s: This DbBackup object does not know the completed time.', __METHOD__)
            );
        }
        return $this->completed;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompleted($completed)
    {
        if (!is_numeric($completed) || empty($completed)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $completed expects an int.', __METHOD__)
            );
        }
        $this->completed = $completed;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeleted()
    {
        if ($this->deleted === null) {
            throw new \RuntimeException(
                sprintf('%s: This DbBackup object does not know the deleted status.', __METHOD__)
            );
        }
        return $this->deleted;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeleted($deleted)
    {
        if (!is_numeric($deleted) || !($deleted == 0 || $deleted == 1)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $deleted expects an int of value 0 or 1.', __METHOD__)
            );
        }
        $this->deleted = $deleted;
    }

    /**
     * {@inheritdoc}
     */
    public function getChecksum()
    {
        if ($this->checksum === null) {
            throw new \RuntimeException(
                sprintf('%s: This DbBackup object does not know the checksum.', __METHOD__)
            );
        }
        return $this->checksum;
    }

    /**
     * {@inheritdoc}
     */
    public function setChecksum($checksum)
    {
        if (!is_string($checksum) || empty($checksum)) {
            throw new \InvalidArgumentException(
                sprintf('%s: $checksum expects a string.', __METHOD__)
            );
        }
        $this->checksum = $checksum;
    }
}
