<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting;

use Acquia\Platform\Cloud\Hosting\Task;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Task
 */
class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getID
     */
    public function testIDPropertyMayBeAccessedViaMethods()
    {
        $task = new Task(1234);
        $this->assertEquals(1234, $task->getID());
    }

    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testIDPropertyMustBeAnInteger()
    {
        $task = new Task('test');
    }

    /**
     * @covers ::create()
     */
    public function testTaskCanBeInstantiatedWithFactoryMethod()
    {
        $task = Task::create(['ID' => 1234]);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Task', $task);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\TaskInterface', $task);

        $task = Task::create(
            [
                'ID' => 1234,
                'queue' => 'code-push',
                'state' => 'done',
                'description' =>  'Deploy code to dev',
                'created' => 11111111111,
                'started' =>  11111111111,
                'completed' =>  11111111111,
                'sender' => 'user@acquia.com',
                'result' => 'done',
                'cookie' => '',
                'logs' => '',

            ]
        );
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Task', $task);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\TaskInterface', $task);
    }

    /**
     * @covers ::getQueue
     * @covers ::setQueue
     */
    public function testQueuePropertyMayBeAccessedViaMethods()
    {
        $queue = 'code-push';
        $task = new Task(1234);
        $task->setQueue($queue);
        $this->assertEquals($queue, $task->getQueue());
    }

    /**
     * @covers ::getQueue
     * @expectedException \RuntimeException
     */
    public function testGetQueueWillThrowExceptionIfPropertyNotSet()
    {
        $task = new Task(1234);
        $task->getQueue();
    }

    /**
     * @covers ::setQueue
     * @expectedException \InvalidArgumentException
     */
    public function testSetQueueWillThrowExceptionIfNotAString()
    {
        $task = new Task(1234);
        $task->setQueue([]);
    }

    /**
     * @covers ::setQueue
     * @expectedException \InvalidArgumentException
     */
    public function testSetQueueWillThrowExceptionIfEmptyString()
    {
        $task = new Task(1234);
        $task->setQueue('');
    }



}
