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

final class Task implements TaskInterface
{
    /**
     * @var int
     */
    private $id;

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

    public function __construct($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s: Task ID must be an integer (%s given)',
                    __METHOD__,
                    is_int($id) ? $id : gettype($id)
                )
            );
        }
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(array $taskData)
    {
        $app = new static($taskData['id']);
        if (isset($taskData['queue'])) {
            $app->setQueue($taskData['queue']);
        }
        if (isset($taskData['state'])) {
            $app->setState($taskData['state']);
        }
        if (isset($taskData['description'])) {
            $app->setDescription($taskData['description']);
        }
        if (isset($taskData['created'])) {
            $app->setCreated($taskData['created']);
        }
        if (isset($taskData['started'])) {
            $app->setStarted($taskData['started']);
        }
        if (isset($taskData['completed'])) {
            $app->setCompleted($taskData['completed']);
        }
        if (isset($taskData['sender'])) {
            $app->setSender($taskData['sender']);
        }
        if (isset($taskData['result'])) {
            $app->setResult($taskData['result']);
        }
        if (isset($taskData['cookie'])) {
            $app->setCookie($taskData['cookie']);
        }
        if (isset($taskData['logs'])) {
            $app->setLogs($taskData['logs']);
        }

        return $app;
    }

    /**
     * {@inheritdoc}
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue()
    {
        if ($this->queue === null) {
            throw new \RuntimeException(
                sprintf('%s: This Task object has no the queue.', __METHOD__)
            );
        }
        return $this->queue;
    }

    /**
     * Add a string.
     *
     * @param string $queue A string.
     */
    public function setQueue($queue)
    {
        if (!is_string($queue) || empty($queue)) {
            throw new \InvalidArgumentException(
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
            throw new \RuntimeException(
              sprintf('%s: This Task object has no the state.', __METHOD__)
            );
        }
        return $this->state;
    }

    /**
     * Add a string.
     *
     * @param string $state A string.
     */
    public function setState($state)
    {
        if (!is_string($state) || empty($state)) {
            throw new \InvalidArgumentException(
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
            throw new \RuntimeException(
              sprintf('%s: This Task object has no description.', __METHOD__)
            );
        }
        return $this->description;
    }

    /**
     * Add a string.
     *
     * @param string $description A string.
     */
    public function setDescription($description)
    {
        if (!is_string($description) || empty($description)) {
            throw new \InvalidArgumentException(
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
            throw new \RuntimeException(
              sprintf('%s: This Task object has no created date.', __METHOD__)
            );
        }
        return $this->created;
    }

    /**
     * Add an integer.
     *
     * @param int $created A UNIX timestamp integer.
     */
    public function setCreated($created)
    {
        if (!is_int($created) || empty($created)) {
            throw new \InvalidArgumentException(
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
        if ($this->started === null) {
            throw new \RuntimeException(
              sprintf('%s: This Task object has no started date.', __METHOD__)
            );
        }
        return $this->started;
    }

    /**
     * Add an integer.
     *
     * @param int $started A UNIX timestamp integer.
     */
    public function setStarted($started)
    {
        if (!is_int($started) || empty($started)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $started expects an integer.', __METHOD__)
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
              sprintf('%s: This Task object has no completed.', __METHOD__)
            );
        }
        return $this->completed;
    }

    /**
     * Add an integer.
     *
     * @param int $completed A UNIX timestamp integer.
     */
    public function setCompleted($completed)
    {
        if (!is_int($completed) || empty($completed)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $completed expects an integer.', __METHOD__)
            );
        }
        $this->completed = $completed;
    }

    /**
 * {@inheritdoc}
 */
    public function getSender()
    {
        if ($this->sender === null) {
            throw new \RuntimeException(
              sprintf('%s: This Task object does not know sender.', __METHOD__)
            );
        }
        return $this->sender;
    }

    /**
     * Add a string.
     *
     * @param string $sender A string
     */
    public function setSender($sender)
    {
        if (!is_string($sender) || empty($sender)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $sender expects an integer.', __METHOD__)
            );
        }
        $this->sender = $sender;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        if ($this->result === null) {
            throw new \RuntimeException(
              sprintf('%s: This Task object does not know result.', __METHOD__)
            );
        }
        return $this->result;
    }

    /**
     * Add a string.
     *
     * @param string $result A string
     */
    public function setResult($result)
    {
        if (!is_string($result) || empty($result)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $result expects a string.', __METHOD__)
            );
        }
        $this->result = $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getCookie()
    {
        if ($this->cookie === null) {
            throw new \RuntimeException(
              sprintf('%s: This Task object does not know cookie.', __METHOD__)
            );
        }
        return $this->cookie;
    }

    /**
     * Add a string.
     *
     * @param string $cookie A string
     */
    public function setCookie($cookie)
    {
        if (!is_string($cookie) || empty($cookie)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $cookie expects a string.', __METHOD__)
            );
        }
        $this->cookie = $cookie;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogs()
    {
        if ($this->logs === null) {
            throw new \RuntimeException(
              sprintf('%s: This Task object has no log data.', __METHOD__)
            );
        }
        return $this->logs;
    }

    /**
     * Add a string.
     *
     * @param string $logs A string
     */
    public function setLogs($logs)
    {
        if (!is_string($logs) || empty($logs)) {
            throw new \InvalidArgumentException(
              sprintf('%s: $logs expects a string.', __METHOD__)
            );
        }
        $this->logs = $logs;
    }
}
