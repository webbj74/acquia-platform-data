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
use Acquia\Platform\Cloud\Hosting\Server\BalancerServerListInterface;
use Acquia\Platform\Cloud\Hosting\Server\DatabaseServerListInterface;
use Acquia\Platform\Cloud\Hosting\Server\EmptyServerListException;
use Acquia\Platform\Cloud\Hosting\Server\FileServerListInterface;
use Acquia\Platform\Cloud\Hosting\Server\ServerList;
use Acquia\Platform\Cloud\Hosting\Server\VcsServerListInterface;
use Acquia\Platform\Cloud\Hosting\Server\WebServerListInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Acquia\Platform\Cloud\Hosting\Server\ServerList
 */
class ServerListTest extends TestCase
{
    private $childrenOfHyperion = ['Helios-10', 'Selene-20', 'Eos-30'];
    private $childrenOfCoeus = ['Lelantos-100', 'Leto-110', 'Asteria-120'];
    private $childrenOfIapetus = ['Atlas-5', 'Prometheus-15', 'Epimetheus-25', 'Menoetius-35'];
    private $childrenOfOceanus = ['Metis-4'];
    private $childrenOfCrius = ['Astraeus-200', 'Pallas-1', 'Perses-3'];

    /**
     * Returns a ServerList for testing.
     *
     * @return ServerList
     *   A list of servers of various types.
     */
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
        $this->assertInstanceOf(ServerList::class, $childrenOfHyperion);
        $this->assertEquals(3, $childrenOfHyperion->count());
        $iterator = $childrenOfHyperion->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Server $server */
            $server = $iterator->current();
            $this->assertInstanceOf(Server::class, $server);
            $this->assertTrue(in_array($server->getName(), $this->childrenOfHyperion));
            $this->assertFalse(in_array($server->getName(), $this->childrenOfIapetus));
            $iterator->next();
        }

        // filter by comma-delimited string
        $childrenOfIapetus = $serverList->filterByName(implode(',', $this->childrenOfIapetus));
        $this->assertInstanceOf(ServerList::class, $childrenOfIapetus);
        $this->assertEquals(4, $childrenOfIapetus->count());
        $iterator = $childrenOfIapetus->getIterator();
        while ($iterator->valid()) {
            /** @var \Acquia\Platform\Cloud\Hosting\Server $server */
            $server = $iterator->current();
            $this->assertInstanceOf(Server::class, $server);
            $this->assertTrue(in_array($server->getName(), $this->childrenOfIapetus));
            $this->assertFalse(in_array($server->getName(), $this->childrenOfHyperion));
            $iterator->next();
        }
    }

    /**
     * @covers ::filterByName
     * @dataProvider exceptionalFilterProvider()
     */
    public function testFilterWillThrowExceptionForBadParameter($filter)
    {
        $this->expectException(InvalidArgumentException::class);
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
     * @dataProvider exceptionalValueProvider()
     */
    public function testOffsetSetWillThrowExceptionForNonServer($value)
    {
        $this->expectException(InvalidArgumentException::class);
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

    /**
     * @covers ::getLowestNumberedServer
     */
    public function testGetLowestNumberedServer()
    {
        $serverList = $this->getBasicServerList();
        $this->assertEquals('Pallas-1', $serverList->getLowestNumberedServer()->getName());

        $serverList = new ServerList();
        $this->expectException(EmptyServerListException::class);
        $serverList->getLowestNumberedServer();
    }

    /**
     * @covers ::offsetGet
     */
    public function testArrayOffsetCanBeServerNameOrInteger()
    {
        $serverList = new ServerList();
        $this->assertNull($serverList['doesntexist']);

        $serverList = $this->getBasicServerList();
        $this->assertNull($serverList['doesntexist']);
        $this->assertEquals('Helios-10', $serverList[0]->getName());
        $this->assertEquals('Leto-110', $serverList[4]->getName());
        $this->assertEquals('Pallas-1', $serverList['Pallas-1']->getName());
    }

    /**
     * @covers ::getFileServers
     */
    public function testGetFileServersWithDedicatedFileServer()
    {
        $serverList = $this->getFullyTieredServerList();
        $this->assertEquals(9, count($serverList));

        /** @var FileServerListInterface $fileSystemServers */
        $fileSystemServers = $serverList->getFileServers();
        $this->assertEquals(2, count($fileSystemServers));

        $this->assertEquals('fs-567', $fileSystemServers[0]->getName());
        $this->assertEquals('fs-678', $fileSystemServers[1]->getName());
    }

    /**
     * @covers ::getBalancerServers
     */
    public function testGetBalancerServers()
    {
        // Full-tier
        $serverList = $this->getFullyTieredServerList();
        $this->assertEquals(9, count($serverList));

        /** @var BalancerServerListInterface $balServers */
        $balServers = $serverList->getBalancerServers();
        $this->assertEquals(2, count($balServers));

        $this->assertEquals('bal-123', $balServers[0]->getName());
        $this->assertEquals('bal-234', $balServers[1]->getName());

        // Single-server
        $serverList = $this->getUntieredServerList();
        $this->assertEquals(4, count($serverList));

        /** @var DatabaseServerListInterface $dbServers */
        $balServers = $serverList->getBalancerServers();
        $this->assertEquals(2, count($balServers));

        $this->assertEquals('bal-123', $balServers[0]->getName());
        $this->assertEquals('bal-234', $balServers[1]->getName());
    }

    /**
     * @covers ::getDatabaseServers
     */
    public function testGetDatabaseServers()
    {
        // Full-tier
        $serverList = $this->getFullyTieredServerList();
        $this->assertEquals(9, count($serverList));

        /** @var DatabaseServerListInterface $dbServers */
        $dbServers = $serverList->getDatabaseServers();
        $this->assertEquals(2, count($dbServers));

        $this->assertEquals('fsdb-345', $dbServers[0]->getName());
        $this->assertEquals('fsdb-456', $dbServers[1]->getName());

        // Multi-tier
        $serverList = $this->getMultiTieredServerList();
        $this->assertEquals(7, count($serverList));

        /** @var DatabaseServerListInterface $dbServers */
        $dbServers = $serverList->getDatabaseServers();
        $this->assertEquals(2, count($dbServers));

        $this->assertEquals('fsdb-345', $dbServers[0]->getName());
        $this->assertEquals('fsdb-456', $dbServers[1]->getName());

        // Single-tier
        $serverList = $this->getTieredServerList();
        $this->assertEquals(5, count($serverList));

        /** @var DatabaseServerListInterface $dbServers */
        $dbServers = $serverList->getDatabaseServers();
        $this->assertEquals(2, count($dbServers));

        $this->assertEquals('ded-345', $dbServers[0]->getName());
        $this->assertEquals('ded-456', $dbServers[1]->getName());

        // Single-server
        $serverList = $this->getUntieredServerList();
        $this->assertEquals(4, count($serverList));

        /** @var DatabaseServerListInterface $dbServers */
        $dbServers = $serverList->getDatabaseServers();
        $this->assertEquals(1, count($dbServers));

        $this->assertEquals('srv-345', $dbServers[0]->getName());
    }

    /**
     * @covers ::getFileServers
     */
    public function testGetFileServersWithoutDedicatedFileServer()
    {
        // Multi-tier
        $serverList = $this->getMultiTieredServerList();
        $this->assertEquals(7, count($serverList));

        /** @var FileServerListInterface $fileSystemServers */
        $fileSystemServers = $serverList->getFileServers();
        $this->assertEquals(2, count($fileSystemServers));

        $this->assertEquals('fsdb-345', $fileSystemServers[0]->getName());
        $this->assertEquals('fsdb-456', $fileSystemServers[1]->getName());

        // Single-tier
        $serverList = $this->getTieredServerList();
        $this->assertEquals(5, count($serverList));

        /** @var FileServerListInterface $fileSystemServers */
        $fileSystemServers = $serverList->getFileServers();
        $this->assertEquals(2, count($fileSystemServers));

        $this->assertEquals('ded-345', $fileSystemServers[0]->getName());
        $this->assertEquals('ded-456', $fileSystemServers[1]->getName());

        // Single-server
        $serverList = $this->getUntieredServerList();
        $this->assertEquals(4, count($serverList));

        /** @var FileServerListInterface $fileSystemServers */
        $fileSystemServers = $serverList->getFileServers();
        $this->assertEquals(1, count($fileSystemServers));

        $this->assertEquals('srv-345', $fileSystemServers[0]->getName());
    }

    /**
     * @covers ::getWebServers
     */
    public function testGetWebServers()
    {
        // Full-tier
        $serverList = $this->getFullyTieredServerList();
        $this->assertEquals(9, count($serverList));

        /** @var WebServerListInterface $webServers */
        $webServers = $serverList->getWebServers();
        $this->assertEquals(2, count($webServers));

        $this->assertEquals('web-789', $webServers[0]->getName());
        $this->assertEquals('web-890', $webServers[1]->getName());

        // Multi-tier
        $serverList = $this->getMultiTieredServerList();
        $this->assertEquals(7, count($serverList));

        /** @var WebServerListInterface $webServers */
        $webServers = $serverList->getWebServers();
        $this->assertEquals(2, count($webServers));

        $this->assertEquals('web-789', $webServers[0]->getName());
        $this->assertEquals('web-890', $webServers[1]->getName());

        // Single-tier
        $serverList = $this->getTieredServerList();
        $this->assertEquals(5, count($serverList));

        /** @var WebServerListInterface $webServers */
        $webServers = $serverList->getWebServers();
        $this->assertEquals(2, count($webServers));

        $this->assertEquals('ded-345', $webServers[0]->getName());
        $this->assertEquals('ded-456', $webServers[1]->getName());

        // Single-server
        $serverList = $this->getUntieredServerList();
        $this->assertEquals(4, count($serverList));

        /** @var WebServerListInterface $webServers */
        $webServers = $serverList->getWebServers();
        $this->assertEquals(1, count($webServers));

        $this->assertEquals('srv-345', $webServers[0]->getName());
    }

    /**
     * @covers ::getVcsServers
     */
    public function testGetVcsServers()
    {
        // Full-tier
        $serverList = $this->getFullyTieredServerList();
        $this->assertEquals(9, count($serverList));

        /** @var VcsServerListInterface $vcsServers */
        $vcsServers = $serverList->getVcsServers();
        $this->assertEquals(1, count($vcsServers));

        $this->assertEquals('vcs-1', $vcsServers[0]->getName());
 
        // Multi-tier
        $serverList = $this->getMultiTieredServerList();
        $this->assertEquals(7, count($serverList));

        /** @var VcsServerListInterface $vcsServers */
        $vcsServers = $serverList->getVcsServers();
        $this->assertEquals(1, count($vcsServers));

        $this->assertEquals('vcs-1', $vcsServers[0]->getName());

        // Single-tier
        $serverList = $this->getTieredServerList();
        $this->assertEquals(5, count($serverList));

        /** @var VcsServerListInterface $vcsServers */
        $vcsServers = $serverList->getVcsServers();
        $this->assertEquals(1, count($vcsServers));

        $this->assertEquals('vcs-1', $vcsServers[0]->getName());

        // Single-server
        $serverList = $this->getUntieredServerList();
        $this->assertEquals(4, count($serverList));

        /** @var VcsServerListInterface $vcsServers */
        $vcsServers = $serverList->getVcsServers();
        $this->assertEquals(1, count($vcsServers));

        $this->assertEquals('vcs-1', $vcsServers[0]->getName());
    }

    private function getUntieredServerList()
    {
        $serverList = new ServerList();
        $serverList->append(Server::create([
            'name' => 'vcs-1',
            'services' => [
                'vcs' => [
                    'vcs_type' => 'git',
                    'vcs_url' => 'appname@vcs-1.test.hosting:appname.git',
                    'vcs_path' => 'tags/2016-04-16.0',
                ],
            ],
        ]));
        $serverList->append(Server::create([
            'name' => 'bal-123',
            'services' => [
                'varnish' => ['status' => 'active'],
            ],
        ]));
        $serverList->append(Server::create([
            'name' => 'bal-234',
            'services' => [
                'varnish' => ['status' => 'hot_spare'],
            ],
        ]));
        $serverList->append(Server::create([
            'name' => 'srv-345',
            'services' => [
                'database' => [],
                'web' => [
                    'php_max_procs' => 10,
                    'status' => 'online',
                    'env_status' => 'active'
                ],
            ],
        ]));
        return $serverList;
    }
    
    private function getTieredServerList()
    {
        $serverList = $this->getUntieredServerList();
        $serverList->offsetUnset(3);
        $serverList->append(Server::create([
            'name' => 'ded-345',
            'services' => [
                'database' => [],
                'web' => [
                    'php_max_procs' => 10,
                    'status' => 'online',
                    'env_status' => 'active'
                ],
            ],
        ]));
        $serverList->append(Server::create([
            'name' => 'ded-456',
            'services' => [
                'database' => [],
                'web' => [
                    'php_max_procs' => 10,
                    'status' => 'online',
                    'env_status' => 'active'
                ],
            ],
        ]));
        
        return $serverList;
    }

    private function getMultiTieredServerList()
    {
        $serverList = $this->getUntieredServerList();
        $serverList->offsetUnset(3);
        $serverList->append(Server::create([
            'name' => 'fsdb-345',
            'services' => [
                'database' => [],
            ],
        ]));
        $serverList->append(Server::create([
            'name' => 'fsdb-456',
            'services' => [
                'database' => [],
            ],
        ]));
        $serverList->append(Server::create([
            'name' => 'web-789',
            'services' => [
                'web' => [
                    'php_max_procs' => 10,
                    'status' => 'online',
                    'env_status' => 'active'
                ],
            ],
        ]));
        $serverList->append(Server::create([
            'name' => 'web-890',
            'services' => [
                'web' => [
                    'php_max_procs' => 10,
                    'status' => 'online',
                    'env_status' => 'active'
                ],
            ],
        ]));
        
        return $serverList;
    }

    private function getFullyTieredServerList()
    {
        $serverList = $this->getMultiTieredServerList();
        $serverList->append(Server::create([
            'name' => 'fs-567',
            'services' => [],
        ]));
        $serverList->append(Server::create([
            'name' => 'fs-678',
            'services' => [],
        ]));
        return $serverList;
    }
}
