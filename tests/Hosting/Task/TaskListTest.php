<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Server;

use Acquia\Platform\Cloud\Hosting\Server;
use Acquia\Platform\Cloud\Hosting\Server\ServerList;

/**
 * @coversDefaultClass Acquia\Platform\Cloud\Hosting\Server\ServerList
 */
class ServerListTest extends \PHPUnit_Framework_TestCase
{
    private $childrenOfHyperion = ['Helios', 'Selene', 'Eos'];
    private $childrenOfCoeus = ['Lelantos', 'Leto', 'Asteria'];
    private $childrenOfIapetus = ['Atlas', 'Prometheus', 'Epimetheus', 'Menoetius'];
    private $childrenOfOceanus = ['Metis'];
    private $childrenOfCrius = ['Astraeus', 'Pallas', 'Perses'];

    protected function getBasicServerList()
    {
        $serverList = new ServerList();
        $childrenOfTitans = array_merge(
            $this->childrenOfHyperion,
            $this->childrenOfCoeus,
            $this->childrenOfIapetus,
            $this->childrenOfOceanus,
            $this->childrenOfCrius
        );
        foreach ($childrenOfTitans as $titanName) {
            $serverList->append(new Server($titanName));
        }
        return $serverList;
    }

    /**
     * @covers ::filterByName()
     */
    public function testServerListCanReturnAFilteredListOfContents()
    {
        $serverList = $this->getBasicServerList();
        $this->assertEquals(14, $serverList->count());

        // filter by array
        $childrenOfHyperion = $serverList->filterByName($this->childrenOfHyperion);
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Server\ServerList', $childrenOfHyperion);
        $this->assertEquals(3, $childrenOfHyperion->count());
        $iterator = $childrenOfHyperion->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Server $server */
            $server = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Server', $server);
            $this->assertTrue(in_array($server->getName(), $this->childrenOfHyperion));
            $this->assertFalse(in_array($server->getName(), $this->childrenOfIapetus));
            $iterator->next();
        }

        // filter by comma-delimited string
        $childrenOfIapetus = $serverList->filterByName(implode(',', $this->childrenOfIapetus));
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Server\ServerList', $childrenOfIapetus);
        $this->assertEquals(4, $childrenOfIapetus->count());
        $iterator = $childrenOfIapetus->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Server $server */
            $server = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Server', $server);
            $this->assertTrue(in_array($server->getName(), $this->childrenOfIapetus));
            $this->assertFalse(in_array($server->getName(), $this->childrenOfHyperion));
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
        $serverList = $this->getBasicServerList();
        $serverList->filterByName($filter);
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
    public function testOffsetSetWillThrowExceptionForNonServer($value)
    {
        $serverList = $this->getBasicServerList();
        $serverList->offsetSet(0, $value);
    }

    public function exceptionalValueProvider()
    {
        return [
            'null' => [null],
            'stdClass' => [new \stdClass()],
        ];
    }
}
