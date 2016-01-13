<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Task;

use Acquia\Platform\Cloud\Hosting\Task\TaskDecoratorMethods;
use Acquia\Platform\Cloud\Hosting\TaskInterface;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\Task\TaskDecoratorMethods
 */
class TaskDecoratorMethodsTest extends \PHPUnit_Framework_TestCase
{
    const TEST_TRAIT = 'Acquia\Platform\Cloud\Hosting\Task\TaskDecoratorMethods';
    const TEST_CLASS = 'Acquia\Platform\Cloud\Hosting\TaskInterface';

    /**
     * @covers ::getTask
     * @covers ::setTask
     */
    public function testTaskDecoratorMethodsMaySetDecoratedTask()
    {
        /** @var TaskDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        /** @var TaskInterface $mockClass   */
        $mockClass = $this->getMockBuilder(self::TEST_CLASS)->getMock();

        $mockTrait->setTask($mockClass);
        $this->assertEquals($mockClass, $mockTrait->getTask());
    }

    /**
     * @covers ::getID
     * @covers ::getQueue
     * @covers ::getState
     * @covers ::getDescription
     * @covers ::getCreated
     * @covers ::getStarted
     * @covers ::getCompleted
     * @covers ::getSender
     * @covers ::getResult
     * @covers ::getCookie
     * @covers ::getLogs
     * @dataProvider getTaskInterfaceGetters
     */
    public function testTaskDecoratorMethodsPassesGettersToTask($getter, $expected)
    {
        /** @var TaskDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockClass = $this->getMockBuilder(self::TEST_CLASS)
            ->getMock();
        $mockClass->expects($this->once())
            ->method($getter)
            ->willReturn($expected);

        $mockTrait->setTask($mockClass);
        $this->assertEquals($expected, call_user_func([$mockTrait, $getter]));
    }

    /**
     * @covers ::setQueue
     * @covers ::setState
     * @covers ::setDescription
     * @covers ::setCreated
     * @covers ::setStarted
     * @covers ::setCompleted
     * @covers ::setSender
     * @covers ::setResult
     * @covers ::setCookie
     * @covers ::setLogs
     * @dataProvider getTaskInterfaceSetters
     */
    public function testTaskDecoratorMethodsPassesSettersToTask($setter, $expected)
    {
        /** @var TaskDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockClass = $this->getMockBuilder(self::TEST_CLASS)
            ->getMock();
        $mockClass->expects($this->once())
            ->method($setter)
            ->with($expected);

        $mockTrait->setTask($mockClass);
        call_user_func([$mockTrait, $setter], $expected);
    }

    public function getTaskInterfaceGetters()
    {
        return [
            ['getID', 1234],
            ['getQueue', 'code-push'],
            ['getState', 'done'],
            ['getDescription', 'Deploy code to dev'],
            ['getCreated', 12345678],
            ['getStarted', 12345678],
            ['getCompleted', 12345678],
            ['getSender', 'cloud-api'],
            ['getResult', 'all done'],
            ['getCookie', 'oatmeal'],
            ['getLogs', "It's log log log"],
        ];
    }

    public function getTaskInterfaceSetters()
    {
        return [
            ['setQueue', 'code-push'],
            ['setState', 'done'],
            ['setDescription', 'Deploy code to dev'],
            ['setCreated', 12345678],
            ['setStarted', 12345678],
            ['setCompleted', 12345678],
            ['setSender', 'cloud-api'],
            ['setResult', 'all done'],
            ['setCookie', 'oatmeal'],
            ['setLogs', "It's log log log"],
        ];
    }
}
