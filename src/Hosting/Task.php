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

use InvalidArgumentException;
use RuntimeException;

final class Task implements TaskInterface
{
    /**
     * @var int
     */
    private $taskID;

    /**
     * @var string
     */
    private $queue;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $created;

    /**
     * @var int
     */
    private $started;

    /**
     * @var int
     */
    private $completed;

    /**
     * @var string
     */
    private $sender;

    /**
     * @var string
     */
    private $result;

    /**
     * @var string
     */
    private $cookie;

    /**
     * @var string
     */
    private $logs;

    public function __construct($taskID)
    {
        if (!is_numeric($taskID)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s: Task ID must be an integer (%s given)',
                    __METHOD__,
                    gettype($taskID)
                )
            );
        }
        $this->taskID = $taskID;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(array $taskData)
    {
        $task = new static($taskData['id']);

        $propertySetters = [
             'queue' => 'setQueue',
             'state' => 'setState',
             'description' => 'setDescription',
             'created' => 'setCreated',
             'started' => 'setStarted',
             'completed' => 'setCompleted',
             'sender' => 'setSender',
             'result' => 'setResult',
             'cookie' => 'setCookie',
             'logs' => 'setLogs',
        ];

        foreach ($propertySetters as $property => $setter) {
            if (isset($taskData[$property])) {
                call_user_func([$task, $setter], $taskData[$property]);
            }
        }

        return $task;
    }

    /**
     * {@inheritdoc}
     */
    public function getID()
    {
        return $this->taskID;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue()
    {
        if ($this->queue === null) {
            throw new RuntimeException(
                sprintf('%s: This Task object has no the queue.', __METHOD__)
            );
        }
        return $this->queue;
    }

    /**
     * {@inheritdoc}
     */
    public function setQueue($queue)
    {
        if (!is_string($queue) || empty($queue)) {
            throw new InvalidArgumentException(
                sprintf('%s: $queue expects a string.', __METHOD__)
            );
        }
        $this->queue = $queue;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        if ($this->state === null) {
            throw new RuntimeException(
                sprintf('%s: This Task object has no the state.', __METHOD__)
            );
        }
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function setState($state)
    {
        if (!is_string($state) || empty($state)) {
            throw new InvalidArgumentException(
                sprintf('%s: $state expects a string.', __METHOD__)
            );
        }
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        if ($this->description === null) {
            throw new RuntimeException(
                sprintf('%s: This Task object has no description.', __METHOD__)
            );
        }
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        if (!is_string($description) || empty($description)) {
            throw new InvalidArgumentException(
                sprintf('%s: $description expects a string.', __METHOD__)
            );
        }
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated()
    {
        if ($this->created === null) {
            throw new RuntimeException(
                sprintf('%s: This Task object has no created date.', __METHOD__)
            );
        }
        return $this->created;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreated($created)
    {
        if (!is_numeric($created) || empty($created)) {
            throw new InvalidArgumentException(
                sprintf('%s: $created expects an integer.', __METHOD__)
            );
        }
        $this->created = $created;
    }

    /**
     * {@inheritdoc}
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * {@inheritdoc}
     */
    public function setStarted($started)
    {
        if (!is_numeric($started) && !is_null($started)) {
            throw new InvalidArgumentException(
                sprintf('%s: $started expects an integer or null value.', __METHOD__)
            );
        }
        $this->started = $started;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompleted($completed)
    {
        if (!is_numeric($completed) && !is_null($completed)) {
            throw new InvalidArgumentException(
                sprintf('%s: $completed expects an integer or null value.', __METHOD__)
            );
        }
        $this->completed = $completed;
    }

    /**
     * {@inheritdoc}
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * {@inheritdoc}
     */
    public function setSender($sender)
    {
        if (!is_string($sender)) {
            throw new InvalidArgumentException(
                sprintf('%s: $sender expects a string.', __METHOD__)
            );
        }
        $this->sender = $sender;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * {@inheritdoc}
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogs()
    {
        if ($this->logs === null) {
            throw new RuntimeException(
                sprintf('%s: This Task object has no log data.', __METHOD__)
            );
        }
        return $this->logs;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogs($logs)
    {
        if (!is_string($logs)) {
            throw new InvalidArgumentException(
                sprintf('%s: $logs expects a string.', __METHOD__)
            );
        }
        $this->logs = $logs;
    }
}
