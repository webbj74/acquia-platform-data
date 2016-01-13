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
     * @expectedException \RuntimeException
     */
    public function testGetStateWillThrowExceptionIfPropertyNotSet()
    {
        $task = new Task(1234);
        $task->getState();
    }

    /**
     * @covers ::setState
     * @expectedException \InvalidArgumentException
     */
    public function testSetStateWillThrowExceptionIfNotAString()
    {
        $task = new Task(1234);
        $task->setState([]);
    }

    /**
     * @covers ::setState
     * @expectedException \InvalidArgumentException
     */
    public function testSetStateWillThrowExceptionIfEmptyString()
    {
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
     * @expectedException \RuntimeException
     */
    public function testGetDescriptionWillThrowExceptionIfPropertyNotSet()
    {
        $task = new Task(1234);
        $task->getDescription();
    }

    /**
     * @covers ::setDescription
     * @expectedException \InvalidArgumentException
     */
    public function testSetDescriptionWillThrowExceptionIfNotAString()
    {
        $task = new Task(1234);
        $task->setDescription([]);
    }

    /**
     * @covers ::setDescription
     * @expectedException \InvalidArgumentException
     */
    public function testSetDescriptionWillThrowExceptionIfEmptyString()
    {
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
     * @expectedException \RuntimeException
     */
    public function testGetCreatedWillThrowExceptionIfPropertyNotSet()
    {
        $task = new Task(1234);
        $task->getCreated();
    }

    /**
     * @covers ::setCreated
     * @expectedException \InvalidArgumentException
     */
    public function testSetCreatedWillThrowExceptionIfNotAnInteger()
    {
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
     * @covers ::getStarted
     * @expectedException \RuntimeException
     */
    public function testGetStartedWillThrowExceptionIfPropertyNotSet()
    {
        $task = new Task(1234);
        $task->getStarted();
    }

    /**
     * @covers ::setStarted
     * @expectedException \InvalidArgumentException
     */
    public function testSetStartedWillThrowExceptionIfNotAnInteger()
    {
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
     * @expectedException \RuntimeException
     */
    public function testGetCompletedWillThrowExceptionIfPropertyNotSet()
    {
        $task = new Task(1234);
        $task->getCompleted();
    }

    /**
     * @covers ::setCompleted
     * @expectedException \InvalidArgumentException
     */
    public function testSetCompletedWillThrowExceptionIfNotAnInteger()
    {
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
     * @covers ::getSender
     * @expectedException \RuntimeException
     */
    public function testGetSenderWillThrowExceptionIfPropertyNotSet()
    {
        $task = new Task(1234);
        $task->getSender();
    }

    /**
     * @covers ::setSender
     * @expectedException \InvalidArgumentException
     */
    public function testSetSenderWillThrowExceptionIfNotAString()
    {
        $task = new Task(1234);
        $task->setSender([]);
    }

    /**
     * @covers ::setSender
     * @expectedException \InvalidArgumentException
     */
    public function testSetSenderWillThrowExceptionIfEmptyString()
    {
        $task = new Task(1234);
        $task->setSender('');
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
     * @expectedException \RuntimeException
     */
    public function testGetLogsWillThrowExceptionIfPropertyNotSet()
    {
        $task = new Task(1234);
        $task->getLogs();
    }

    /**
     * @covers ::setLogs
     * @expectedException \InvalidArgumentException
     */
    public function testSetLogsWillThrowExceptionIfNotAString()
    {
        $task = new Task(1234);
        $task->setLogs([]);
    }
}
