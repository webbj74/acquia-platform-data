<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Application;

use Acquia\Platform\Cloud\Hosting\Application;
use Acquia\Platform\Cloud\Hosting\Application\ApplicationList;

/**
 * @coversDefaultClass Acquia\Platform\Cloud\Hosting\Application\ApplicationList
 */
class ApplicationListTest extends \PHPUnit_Framework_TestCase
{
    private $childrenOfHyperion = ['Helios', 'Selene', 'Eos'];
    private $childrenOfCoeus = ['Lelantos', 'Leto', 'Asteria'];
    private $childrenOfIapetus = ['Atlas', 'Prometheus', 'Epimetheus', 'Menoetius'];
    private $childrenOfOceanus = ['Metis'];
    private $childrenOfCrius = ['Astraeus', 'Pallas', 'Perses'];

    protected function getBasicApplicationList()
    {
        $applicationList = new ApplicationList();
        $childrenOfTitans = array_merge(
            $this->childrenOfHyperion,
            $this->childrenOfCoeus,
            $this->childrenOfIapetus,
            $this->childrenOfOceanus,
            $this->childrenOfCrius
        );
        foreach ($childrenOfTitans as $titanName) {
            $applicationList->append(new Application($titanName));
        }
        return $applicationList;
    }

    /**
     * @covers ::filterByName()
     */
    public function testApplicationListCanReturnAFilteredListOfContents()
    {
        $applicationList = $this->getBasicApplicationList();
        $this->assertEquals(14, $applicationList->count());

        // filter by array
        $childrenOfHyperion = $applicationList->filterByName($this->childrenOfHyperion);
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Application\ApplicationList', $childrenOfHyperion);
        $this->assertEquals(3, $childrenOfHyperion->count());
        $iterator = $childrenOfHyperion->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Application $application */
            $application = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Application', $application);
            $this->assertTrue(in_array($application->getName(), $this->childrenOfHyperion));
            $this->assertFalse(in_array($application->getName(), $this->childrenOfIapetus));
            $iterator->next();
        }

        // filter by comma-delimited string
        $childrenOfIapetus = $applicationList->filterByName(implode(',', $this->childrenOfIapetus));
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Application\ApplicationList', $childrenOfIapetus);
        $this->assertEquals(4, $childrenOfIapetus->count());
        $iterator = $childrenOfIapetus->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Application $application */
            $application = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Application', $application);
            $this->assertTrue(in_array($application->getName(), $this->childrenOfIapetus));
            $this->assertFalse(in_array($application->getName(), $this->childrenOfHyperion));
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
        $applicationList = $this->getBasicApplicationList();
        $applicationList->filterByName($filter);
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
    public function testOffsetSetWillThrowExceptionForNonApplication($value)
    {
        $applicationList = $this->getBasicApplicationList();
        $applicationList->offsetSet(0, $value);
    }

    public function exceptionalValueProvider()
    {
        return [
            'null' => [null],
            'stdClass' => [new \stdClass()],
        ];
    }
}
