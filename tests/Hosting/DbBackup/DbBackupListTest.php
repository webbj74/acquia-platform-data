<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\DbBackup;

use Acquia\Platform\Cloud\Hosting\DbBackup;
use Acquia\Platform\Cloud\Hosting\DbBackup\DbBackupList;

/**
 * @coversDefaultClass Acquia\Platform\Cloud\Hosting\DbBackup\DbBackupList
 */
class DbBackupListTest extends \PHPUnit_Framework_TestCase
{
    private $primesUnderTen = [2, 3, 5, 7];
    private $primesUnderTwenty = [11, 13, 17, 19];
    private $primesUnderThirty = [23, 29];
    private $primesUnderForty = [31, 37];
    private $primesUnderFifty = [41, 43, 47];

    protected function getBasicDbBackupList()
    {
        $dbBackupList = new DbBackupList();
        $bunchOfPrimes = array_merge(
            $this->primesUnderTen,
            $this->primesUnderTwenty,
            $this->primesUnderThirty,
            $this->primesUnderForty,
            $this->primesUnderFifty
        );
        foreach ($bunchOfPrimes as $prime) {
            $dbBackupList->append(new DbBackup($prime));
        }
        return $dbBackupList;
    }

    /**
     * @covers ::filterById()
     */
    public function testDbBackupListCanReturnAFilteredListOfContents()
    {
        $dbBackupList = $this->getBasicDbBackupList();
        $this->assertEquals(15, $dbBackupList->count());

        // filter by array
        $primesUnderTen = $dbBackupList->filterById($this->primesUnderTen);
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\DbBackup\DbBackupList', $primesUnderTen);
        $this->assertEquals(4, $primesUnderTen->count());
        $iterator = $primesUnderTen->getIterator();
        while ($iterator->valid()) {
            /* @var \Acquia\Platform\Cloud\Hosting\DbBackup $dbBackup */
            $dbBackup = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\DbBackup', $dbBackup);
            $this->assertTrue(in_array($dbBackup->getId(), $this->primesUnderTen));
            $this->assertFalse(in_array($dbBackup->getId(), $this->primesUnderTwenty));
            $iterator->next();
        }
    }

    /**
     * @covers ::filterById
     * @expectedException \InvalidArgumentException
     * @dataProvider exceptionalFilterProvider()
     */
    public function testFilterWillThrowExceptionForBadParameter($filter)
    {
        $dbBackupList = $this->getBasicDbBackupList();
        $dbBackupList->filterById($filter);
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
     * @expectedException \InvalidArgumentException
     * @dataProvider exceptionalValueProvider()
     */
    public function testOffsetSetWillThrowExceptionForNonDbBackup($value)
    {
        $dbBackupList = $this->getBasicDbBackupList();
        $dbBackupList->offsetSet(0, $value);
    }

    public function exceptionalValueProvider()
    {
        return [
            'null' => [null],
            'stdClass' => [new \stdClass()],
        ];
    }
}
