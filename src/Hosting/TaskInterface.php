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
 * A Task corresponds to a process running on our hosting. It contains:
 * - An id, eg. 1234
 * - Queue, for type of task, eg. code-push or files-migrate
 * - State, where the task is at, eg. done or error
 * - Description, what the task is, eg. "Deploy code to dev"
 * - Created, timestamp when task was created
 * - Started, timestamp when task actually started
 * - Completed, timestamp when a task is completed, even unsuccessfully
 * - Sender, who created the task, eg. cloud_api or user@acquia.com
 * - Result, output returned when the task finishes
 * - Cookie, cookie information @todo need to know more about what this is
 * - Logs, a string with log information
 */
interface TaskInterface
{
    /**
     * Factory method for Task classes.
     *
     * @param array $taskData
     *
     * @return TaskInterface
     */
    public static function create(array $taskData);

    /**
     * Returns the ID of the task.
     *
     * @return string The ID of the task.
     */
    public function getID();

    /**
     * Returns the queue name for the task. For example:
     * - code-push
     * - files-migrate
     *
     * @return string The queue name for the task.
     */
    public function getQueue();

    /**
     * Sets the queue name for the task.
     *
     * @param string $queue A string name for the queue.
     */
    public function setQueue($queue);

    /**
     * Returns the state of the task. For example:
     *  - done
     *  - error
     *
     * @return string State of the task.
     */
    public function getState();

    /**
     * Sets the state of the task.
     *
     * @param string $state State of the task.
     */
    public function setState($state);

    /**
     * Returns the description of the task. For example:
     *  - Pushing code to dev
     *
     * @return string Description of the task.
     */
    public function getDescription();

    /**
     * Sets the description of the task.
     *
     * @param string $description Description of the task.
     */
    public function setDescription($description);

    /**
     * Returns the UNIX timestamp of when the task was created.
     *
     * @return int UNIX Timestamp when the task was created.
     */
    public function getCreated();

    /**
     * Sets the UNIX timestamp for when the task was created.
     *
     * @param int $created UNIX timestamp when the task was created.
     */
    public function setCreated($created);

    /**
     * Returns the UNIX timestamp of when the task was started.
     *
     * @return int|null UNIX Timestamp when the task was started.
     */
    public function getStarted();

    /**
     * Sets the UNIX timestamp for when the task was started.
     *
     * @param int|null $started UNIX timestamp when the task was started.
     */
    public function setStarted($started);

    /**
     * Returns the UNIX timestamp of when the task was completed.
     *
     * @return int|null UNIX Timestamp when the task was completed.
     */
    public function getCompleted();

    /**
     * Sets the UNIX timestamp for when the task was completed.
     *
     * @param int|null $completed UNIX timestamp when the task was completed.
     */
    public function setCompleted($completed);

    /**
     * Returns the sender, or creator, of the task. For example:
     * - cloud_api
     * - user@acquia.com
     *
     * @return string The sender of the task.
     */
    public function getSender();

    /**
     * Sets the sender for a task.
     * @param string $sender The sender of the task.
     */
    public function setSender($sender);

    /**
     * Returns the result message after the task finishes.
     *
     * @return string Result of the task finishing.
     */
    public function getResult();

    /**
     * Sets the result when the task finishes.
     *
     * @param string $result The result message after the task completes.
     */
    public function setResult($result);

    /**
     * Returns the cookie for a task, if it exists.
     *
     * @return string Cookie information.
     */
    public function getCookie();

    /**
     * Sets the cookie information for a task.
     *
     * @param string $cookie Cookie information for the task.
     */
    public function setCookie($cookie);

    /**
     * Returns log information for the task.
     *
     * @return string Log information for the task.
     */
    public function getLogs();

    /**
     * Sets the log information for a task.
     *
     * @param string $logs Log information for the task.
     */
    public function setLogs($logs);
}
