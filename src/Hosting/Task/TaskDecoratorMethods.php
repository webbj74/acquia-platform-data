<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Task;

use Acquia\Platform\Cloud\Hosting\TaskInterface;

trait TaskDecoratorMethods
{
    /**
     * @var TaskInterface
     */
    protected $task;

    /**
     * Returns the decorated task instance.
     *
     * @return TaskInterface the decorated Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Sets the task instance being decorated.
     *
     * @param TaskInterface $task the Task to decorate
     */
    public function setTask(TaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * {@inheritdoc}
     */
    public function getID()
    {
        return $this->task->getID();
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue()
    {
        return $this->task->getQueue();
    }

    /**
     * {@inheritdoc}
     */
    public function setQueue($queue)
    {
        $this->task->setQueue($queue);
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->task->getState();
    }

    /**
     * {@inheritdoc}
     */
    public function setState($state)
    {
        $this->task->setState($state);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->task->getDescription();
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->task->setDescription($description);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated()
    {
        return $this->task->getCreated();
    }

    /**
     * {@inheritdoc}
     */
    public function setCreated($created)
    {
        $this->task->setCreated($created);
    }

    /**
     * {@inheritdoc}
     */
    public function getStarted()
    {
        return $this->task->getStarted();
    }

    /**
     * {@inheritdoc}
     */
    public function setStarted($started)
    {
        $this->task->setState($started);
    }

    /**
     * {@inheritdoc}
     */
    public function getCompleted()
    {
        return $this->task->getCompleted();
    }

    /**
     * {@inheritdoc}
     */
    public function setCompleted($completed)
    {
        $this->task->setCompleted($completed);
    }

    /**
     * {@inheritdoc}
     */
    public function getSender()
    {
        return $this->task->getSender();
    }

    /**
     * {@inheritdoc}
     */
    public function setSender($sender)
    {
        $this->task->setSender($sender);
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->task->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function setResult($result)
    {
        $this->task->setResult($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getCookie()
    {
        return $this->task->getCookie();
    }

    /**
     * {@inheritdoc}
     */
    public function setCookie($cookie)
    {
        $this->task->setCookie($cookie);
    }

    /**
     * {@inheritdoc}
     */
    public function getLogs()
    {
        return $this->task->getLogs();
    }

    /**
     * {@inheritdoc}
     */
    public function setLogs($logs)
    {
        $this->task->getLogs($logs);
    }

}
