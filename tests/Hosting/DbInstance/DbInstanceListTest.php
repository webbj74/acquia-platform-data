<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\DbInstance;

use Acquia\Platform\Cloud\Hosting\DbInstance;
use Acquia\Platform\Cloud\Hosting\DbInstance\DbInstanceList;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Acquia\Platform\Cloud\Hosting\DbInstance\DbInstanceList
 */
class DbInstanceListTest extends TestCase
{
    private $childrenOfHyperion = ['Helios', 'Selene', 'Eos'];
    private $childrenOfCoeus = ['Lelantos', 'Leto', 'Asteria'];
    private $childrenOfIapetus = ['Atlas', 'Prometheus', 'Epimetheus', 'Menoetius'];
    private $childrenOfOceanus = ['Metis'];
    private $childrenOfCrius = ['Astraeus', 'Pallas', 'Perses'];

    protected function getBasicDbInstanceList()
    {
        $dbInstanceList = new DbInstanceList();
        $childrenOfTitans = array_merge(
            $this->childrenOfHyperion,
            $this->childrenOfCoeus,
            $this->childrenOfIapetus,
            $this->childrenOfOceanus,
            $this->childrenOfCrius
        );
        foreach ($childrenOfTitans as $titanName) {
            $dbInstanceList->append(new DbInstance($titanName));
        }
        return $dbInstanceList;
    }

    /**
     * @covers ::filterByName()
     */
    public function testDbInstanceListCanReturnAFilteredListOfContents()
    {
        $dbInstanceList = $this->getBasicDbInstanceList();
        $this->assertEquals(14, $dbInstanceList->count());

        // filter by array
        $childrenOfHyperion = $dbInstanceList->filterByName($this->childrenOfHyperion);
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\DbInstance\DbInstanceList', $childrenOfHyperion);
        $this->assertEquals(3, $childrenOfHyperion->count());
        $iterator = $childrenOfHyperion->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\DbInstance $dbInstance */
            $dbInstance = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\DbInstance', $dbInstance);
            $this->assertTrue(in_array($dbInstance->getInstanceName(), $this->childrenOfHyperion));
            $this->assertFalse(in_array($dbInstance->getInstanceName(), $this->childrenOfIapetus));
            $iterator->next();
        }

        // filter by comma-delimited string
        $childrenOfIapetus = $dbInstanceList->filterByName(implode(',', $this->childrenOfIapetus));
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\DbInstance\DbInstanceList', $childrenOfIapetus);
        $this->assertEquals(4, $childrenOfIapetus->count());
        $iterator = $childrenOfIapetus->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\DbInstance $dbInstance */
            $dbInstance = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\DbInstance', $dbInstance);
            $this->assertTrue(in_array($dbInstance->getInstanceName(), $this->childrenOfIapetus));
            $this->assertFalse(in_array($dbInstance->getInstanceName(), $this->childrenOfHyperion));
            $iterator->next();
        }
    }

    /**
     * @covers ::filterByName
     * @expectedException \InvalidArgumentException
     * @dataProvider exceptionalFilterProvider()
     */
    public function testFilterWillThrowExceptionForBadParameter($filter)
    {
        $dbInstanceList = $this->getBasicDbInstanceList();
        $dbInstanceList->filterByName($filter);
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
    public function testOffsetSetWillThrowExceptionForNonDbInstance($value)
    {
        $dbInstanceList = $this->getBasicDbInstanceList();
        $dbInstanceList->offsetSet(0, $value);
    }

    public function exceptionalValueProvider()
    {
        return [
            'null' => [null],
            'stdClass' => [new \stdClass()],
        ];
    }
}
