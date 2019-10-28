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
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Task
 */
class TaskTest extends TestCase
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
     */
    public function testIDPropertyMustBeAnInteger()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task('test');
    }

    /**
     * @covers ::create()
     */
    public function testTaskCanBeInstantiatedWithFactoryMethod()
    {
        $task = Task::create(['id' => 1234]);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\Task', $task);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\TaskInterface', $task);

        $task = Task::create(
            [
                'id' => 1234,
                'queue' => 'code-push',
                'state' => 'done',
                'description' =>  'Deploy code to dev',
                'created' => 11111111111,
                'started' =>  11111111111,
                'completed' =>  11111111111,
                'sender' => 'user@acquia.com',
                'result' => 'done',
                'cookie' => 'oatmeal',
                'logs' => 'what rolls down stairs',

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
     */
    public function testGetQueueWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $task = new Task(1234);
        $task->getQueue();
    }

    /**
     * @covers ::setQueue
     */
    public function testSetQueueWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setQueue([]);
    }

    /**
     * @covers ::setQueue
     */
    public function testSetQueueWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setQueue('');
    }

    /**
     * @covers ::getState
     * @covers ::setState
     */
    public function testStatePropertyMayBeAccessedViaMethods()
    {
        $state = 'error';
        $task = new Task(1234);
        $task->setState($state);
        $this->assertEquals($state, $task->getState());
    }

    /**
     * @covers ::getState
     */
    public function testGetStateWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $task = new Task(1234);
        $task->getState();
    }

    /**
     * @covers ::setState
     */
    public function testSetStateWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setState([]);
    }

    /**
     * @covers ::setState
     */
    public function testSetStateWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setState('');
    }

    /**
     * @covers ::getDescription
     * @covers ::setDescription
     */
    public function testDescriptionPropertyMayBeAccessedViaMethods()
    {
        $description = 'Push code from dev to prod';
        $task = new Task(1234);
        $task->setDescription($description);
        $this->assertEquals($description, $task->getDescription());
    }

    /**
     * @covers ::getDescription
     */
    public function testGetDescriptionWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $task = new Task(1234);
        $task->getDescription();
    }

    /**
     * @covers ::setDescription
     */
    public function testSetDescriptionWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setDescription([]);
    }

    /**
     * @covers ::setDescription
     */
    public function testSetDescriptionWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setDescription('');
    }

    /**
     * @covers ::getCreated
     * @covers ::setCreated
     */
    public function testCreatedPropertyMayBeAccessedViaMethods()
    {
        $created = 123456789;
        $task = new Task(1234);
        $task->setCreated($created);
        $this->assertEquals($created, $task->getCreated());
    }

    /**
     * @covers ::getCreated
     */
    public function testGetCreatedWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $task = new Task(1234);
        $task->getCreated();
    }

    /**
     * @covers ::setCreated
     */
    public function testSetCreatedWillThrowExceptionIfNotAnInteger()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setCreated(' ');
    }

    /**
     * @covers ::getStarted
     * @covers ::setStarted
     */
    public function testStartedPropertyMayBeAccessedViaMethods()
    {
        $started = 123456789;
        $task = new Task(1234);
        $task->setStarted($started);
        $this->assertEquals($started, $task->getStarted());
    }

    /**
     * @covers ::setStarted
     */
    public function testSetStartedWillThrowExceptionIfNotAnInteger()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setStarted(' ');
    }

    /**
     * @covers ::getCompleted
     * @covers ::setCompleted
     */
    public function testCompletedPropertyMayBeAccessedViaMethods()
    {
        $completed = 123456789;
        $task = new Task(1234);
        $task->setCompleted($completed);
        $this->assertEquals($completed, $task->getCompleted());
    }

    /**
     * @covers ::getCompleted
     */
    public function testGetCompletedWillReturnNullIfPropertyNotSet()
    {
        $task = new Task(1234);
        $this->assertNull($task->getCompleted());
    }

    /**
     * @covers ::setCompleted
     */
    public function testSetCompletedWillThrowExceptionIfNotAnInteger()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setCompleted(' ');
    }

    /**
     * @covers ::getSender
     * @covers ::setSender
     */
    public function testSenderPropertyMayBeAccessedViaMethods()
    {
        $sender = 'cloud-api';
        $task = new Task(1234);
        $task->setSender($sender);
        $this->assertEquals($sender, $task->getSender());
    }

    /**
     * @covers ::setSender
     */
    public function testSetSenderWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setSender([]);
    }

    /**
     * @covers ::getResult
     * @covers ::setResult
     */
    public function testResultPropertyMayBeAccessedViaMethods()
    {
        $result = 'Task complete';
        $task = new Task(1234);
        $task->setResult($result);
        $this->assertEquals($result, $task->getResult());
    }

    /**
     * @covers ::getCookie
     * @covers ::setCookie
     */
    public function testCookiePropertyMayBeAccessedViaMethods()
    {
        $cookie = 'oatmeal';
        $task = new Task(1234);
        $task->setCookie($cookie);
        $this->assertEquals($cookie, $task->getCookie());
    }

    /**
     * @covers ::getLogs
     * @covers ::setLogs
     */
    public function testLogsPropertyMayBeAccessedViaMethods()
    {
        $logs = 'What rolls down stairs, comes over in pairs...';
        $task = new Task(1234);
        $task->setLogs($logs);
        $this->assertEquals($logs, $task->getLogs());
    }

    /**
     * @covers ::getLogs
     */
    public function testGetLogsWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $task = new Task(1234);
        $task->getLogs();
    }

    /**
     * @covers ::setLogs
     */
    public function testSetLogsWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(1234);
        $task->setLogs([]);
    }
}
