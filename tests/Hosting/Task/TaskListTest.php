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

use Acquia\Platform\Cloud\Hosting\Task;
use Acquia\Platform\Cloud\Hosting\Task\TaskList;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Acquia\Platform\Cloud\Hosting\Task\TaskList
 */
class TaskListTest extends TestCase
{
    private $idsOfHyperion = [123, 345, 567];
    private $idsOfCoeus = [890, 980, 827];
    private $idsOfIapetus = [999, 888, 777];
    private $idsOfOceanus = [1234];
    private $idsOfCrius = [666, 999];

    protected function getBasicTaskList()
    {
        $taskList = new TaskList();
        $idsOfTitans = array_merge(
            $this->idsOfHyperion,
            $this->idsOfCoeus,
            $this->idsOfIapetus,
            $this->idsOfOceanus,
            $this->idsOfCrius
        );
        foreach ($idsOfTitans as $titanID) {
            $taskList->append(new Task($titanID));
        }
        return $taskList;
    }

    /**
     * @covers ::filterByIDs()
     */
    public function testTaskListCanReturnAFilteredListOfContents()
    {
        $taskList = $this->getBasicTaskList();
        $this->assertEquals(12, $taskList->count());

        // filter by array
        $idsOfHyperion = $taskList->filterByIDs($this->idsOfHyperion);
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Task\TaskList', $idsOfHyperion);
        $this->assertEquals(3, $idsOfHyperion->count());
        $iterator = $idsOfHyperion->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Task $task */
            $task = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Task', $task);
            $this->assertTrue(in_array($task->getID(), $this->idsOfHyperion));
            $this->assertFalse(in_array($task->getID(), $this->idsOfIapetus));
            $iterator->next();
        }

        // filter by comma-delimited string
        $idsOfIapetus = $taskList->filterByIDs(implode(',', $this->idsOfIapetus));
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Task\TaskList', $idsOfIapetus);
        $this->assertEquals(4, $idsOfIapetus->count());
        $iterator = $idsOfIapetus->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Task $task */
            $task = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Task', $task);
            $this->assertTrue(in_array($task->getID(), $this->idsOfIapetus));
            $this->assertFalse(in_array($task->getID(), $this->idsOfHyperion));
            $iterator->next();
        }
    }

    /**
     * @covers ::filterByIDs
     * @dataProvider exceptionalFilterProvider()
     */
    public function testFilterWillThrowExceptionForBadParameter($filter)
    {
        $this->expectException(InvalidArgumentException::class);
        $taskList = $this->getBasicTaskList();
        $taskList->filterByIDs($filter);
    }

    public function exceptionalFilterProvider()
    {
        return [
            'null' => [null],
            'stdClass' => [new \stdClass()],
        ];
    }

    /**
     * @covers ::offsetSet
     * @dataProvider exceptionalValueProvider()
     */
    public function testOffsetSetWillThrowExceptionForNonTask($value)
    {
        $this->expectException(InvalidArgumentException::class);
        $taskList = $this->getBasicTaskList();
        $taskList->offsetSet(0, $value);
    }

    public function exceptionalValueProvider()
    {
        return [
            'null' => [null],
            'stdClass' => [new \stdClass()],
        ];
    }
}
