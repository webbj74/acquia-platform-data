<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Environment;

use Acquia\Platform\Cloud\Hosting\Environment;
use Acquia\Platform\Cloud\Hosting\Environment\EnvironmentList;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Acquia\Platform\Cloud\Hosting\Environment\EnvironmentList
 */
class EnvironmentListTest extends TestCase
{
    private $childrenOfLeto = ['Apollo','Artemis'];
    private $childrenOfAtlas = ['Hesperides', 'Hyades', 'Hyas', 'Pleiades', 'Calypso', 'Dione', 'Maera'];

    protected function getBasicEnvironmentList()
    {
        $environmentList = new EnvironmentList();
        $childrenOfTitans = array_merge($this->childrenOfLeto, $this->childrenOfAtlas);
        foreach ($childrenOfTitans as $titanName) {
            $env = new Environment($titanName);
            $env->setMachineName('myapp' . $titanName);
            $env->setUnixUserName("myapp.{$titanName}");
            $environmentList->append($env);
        }
        return $environmentList;
    }

    /**
     * @covers ::filterByName()
     */
    public function testEnvironmentListCanReturnAFilteredListOfContents()
    {
        $environmentList = $this->getBasicEnvironmentList();
        $this->assertEquals(9, $environmentList->count());

        // filter by array
        $environmentsOfLeto = $environmentList->filterByName($this->childrenOfLeto);
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Environment\EnvironmentList', $environmentsOfLeto);
        $this->assertEquals(2, $environmentsOfLeto->count());
        $iterator = $environmentsOfLeto->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Environment $environment */
            $environment = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Environment', $environment);
            $this->assertTrue(in_array($environment->getName(), $this->childrenOfLeto));
            $this->assertFalse(in_array($environment->getName(), $this->childrenOfAtlas));
            $iterator->next();
        }

        // filter by comma-delimited string
        $environmentsOfAtlas = $environmentList->filterByName(implode(',', $this->childrenOfAtlas));
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Environment\EnvironmentList', $environmentsOfAtlas);
        $this->assertEquals(7, $environmentsOfAtlas->count());
        $iterator = $environmentsOfAtlas->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Environment $environment */
            $environment = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Environment', $environment);
            $this->assertTrue(in_array($environment->getName(), $this->childrenOfAtlas));
            $this->assertFalse(in_array($environment->getName(), $this->childrenOfLeto));
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
        $environmentList = $this->getBasicEnvironmentList();
        $environmentList->filterByName($filter);
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
    public function testOffsetSetWillThrowExceptionForNonEnvironment($value)
    {
        $environmentList = $this->getBasicEnvironmentList();
        $environmentList->offsetSet(0, $value);
    }

    public function exceptionalValueProvider()
    {
        return [
            'null' => [null],
            'stdClass' => [new \stdClass()],
        ];
    }

    /**
     * @covers ::getNames
     */
    public function testGetNames()
    {
        $environmentList = $this->getBasicEnvironmentList()->filterByName($this->childrenOfLeto);
        $expected = [
            'Apollo' => 'myappApollo',
            'Artemis' => 'myappArtemis',
        ];
        $this->assertEquals($expected, $environmentList->getNames());
    }

    /**
     * @covers ::getEnvironmentByMachineName
     */
    public function testGetEnvironmentByMachineName()
    {
        $environmentList = $this->getBasicEnvironmentList();
        $this->assertEquals(
            'Apollo',
            $environmentList->getEnvironmentByMachineName('myappApollo')->getName()
        );
        $this->assertEquals(
            'Artemis',
            $environmentList->getEnvironmentByMachineName('myappArtemis')->getName()
        );
    }

    /**
     * @covers ::getEnvironmentByApplicationQualifiedName
     */
    public function testGetEnvironmentByApplicationQualifiedName()
    {
        $environmentList = $this->getBasicEnvironmentList();
        $this->assertEquals(
            'Apollo',
            $environmentList->getEnvironmentByApplicationQualifiedName('myapp.Apollo')->getName()
        );
        $this->assertEquals(
            'Artemis',
            $environmentList->getEnvironmentByApplicationQualifiedName('myapp.Artemis')->getName()
        );
    }

    /**
     * @covers ::offsetGet
     */
    public function testCanAccessElementByEnvironmentNameOrIndex()
    {
        $environmentList = $this->getBasicEnvironmentList();
        $this->assertEquals(
            'Apollo',
            $environmentList[0]->getName()
        );
        $this->assertEquals(
            'Artemis',
            $environmentList[1]->getName()
        );
        $this->assertEquals(
            'Apollo',
            $environmentList['myappApollo']->getName()
        );
        $this->assertEquals(
            'Artemis',
            $environmentList['myappArtemis']->getName()
        );
        $this->assertEquals(
            'Apollo',
            $environmentList['myapp.Apollo']->getName()
        );
        $this->assertEquals(
            'Artemis',
            $environmentList['myapp.Artemis']->getName()
        );
    }
}
