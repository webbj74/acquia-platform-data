<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\Site;

use Acquia\Platform\Cloud\Hosting\Site;
use Acquia\Platform\Cloud\Hosting\Site\SiteList;

/**
 * @coversDefaultClass Acquia\Platform\Cloud\Hosting\Site\SiteList
 */
class SiteListTest extends \PHPUnit_Framework_TestCase
{
    private $childrenOfHyperion = ['Helios', 'Selene', 'Eos'];
    private $childrenOfCoeus = ['Lelantos', 'Leto', 'Asteria'];
    private $childrenOfIapetus = ['Atlas', 'Prometheus', 'Epimetheus', 'Menoetius'];
    private $childrenOfOceanus = ['Metis'];
    private $childrenOfCrius = ['Astraeus', 'Pallas', 'Perses'];

    protected function getBasicSiteList()
    {
        $siteList = new SiteList();
        $childrenOfTitans = array_merge(
            $this->childrenOfHyperion,
            $this->childrenOfCoeus,
            $this->childrenOfIapetus,
            $this->childrenOfOceanus,
            $this->childrenOfCrius
        );
        foreach ($childrenOfTitans as $titanName) {
            $siteList->append(new Site($titanName));
        }
        return $siteList;
    }

    /**
     * @covers ::filterByName()
     */
    public function testSiteListCanReturnAFilteredListOfContents()
    {
        $siteList = $this->getBasicSiteList();
        $this->assertEquals(14, $siteList->count());

        // filter by array
        $childrenOfHyperion = $siteList->filterByName($this->childrenOfHyperion);
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Site\SiteList', $childrenOfHyperion);
        $this->assertEquals(3, $childrenOfHyperion->count());
        $iterator = $childrenOfHyperion->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Site $site */
            $site = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Site', $site);
            $this->assertTrue(in_array($site->getName(), $this->childrenOfHyperion));
            $this->assertFalse(in_array($site->getName(), $this->childrenOfIapetus));
            $iterator->next();
        }

        // filter by comma-delimited string
        $childrenOfIapetus = $siteList->filterByName(implode(',', $this->childrenOfIapetus));
        $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Site\SiteList', $childrenOfIapetus);
        $this->assertEquals(4, $childrenOfIapetus->count());
        $iterator = $childrenOfIapetus->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Site $site */
            $site = $iterator->current();
            $this->assertInstanceOf('Acquia\Platform\Cloud\Hosting\Site', $site);
            $this->assertTrue(in_array($site->getName(), $this->childrenOfIapetus));
            $this->assertFalse(in_array($site->getName(), $this->childrenOfHyperion));
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
        $siteList = $this->getBasicSiteList();
        $siteList->filterByName($filter);
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
    public function testOffsetSetWillThrowExceptionForNonSite($value)
    {
        $siteList = $this->getBasicSiteList();
        $siteList->offsetSet(0, $value);
    }

    public function exceptionalValueProvider()
    {
        return [
            'null' => [null],
            'stdClass' => [new \stdClass()],
        ];
    }
}
