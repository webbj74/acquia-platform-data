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

use Acquia\Platform\Cloud\Hosting\DbBackup;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\DbBackup
 */
class DbBackupTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getId
     */
    public function testIdPropertyMayBeAccessedViaMethods()
    {
        $dbBackup = new DbBackup(12345678);
        $this->assertEquals(12345678, $dbBackup->getId());
    }

    /**
     * @covers ::__construct
     */
    public function testIdPropertyMustBeAnInt()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup([]);
    }

    /**
     * @covers ::create()
     */
    public function testDbBackupCanBeInstantiatedWithFactoryMethod()
    {
        $dbBackup = DbBackup::create(['id' => 12345678]);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\DbBackup', $dbBackup);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\DbBackupInterface', $dbBackup);

        $dbBackup = DbBackup::create(
            [
                'id' => 12345678,
                'type' => 'daily',
                'name' => 'sitename',
                'link' => 'https://www.acquia.com/',
                'path' => 'backups/user-prod-db-backup.sql.gz',
                'started' => 1468218381,
                'completed' => 1468219381,
                'deleted' => 0,
                'checksum' => 'a9e3dac5c312f49415b613aff078f5dd',
            ]
        );
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\DbBackup', $dbBackup);
        $this->assertInstanceOf('\Acquia\Platform\Cloud\Hosting\DbBackupInterface', $dbBackup);
    }

    /**
     * @covers ::getType
     * @covers ::setType
     */
    public function testTypePropertyMayBeAccessedViaMethods()
    {
        $type = 'daily';
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setType($type);
        $this->assertEquals($type, $dbBackup->getType());
    }

    /**
     * @covers ::getType
     */
    public function testGetTypeWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getType();
    }

    /**
     * @covers ::setType
     */
    public function testSetTypeWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setType([]);
    }

    /**
     * @covers ::setType
     */
    public function testSetTypeWillThrowExceptionIfEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setType('');
    }

    /**
     * @covers ::getName
     * @covers ::setName
     */
    public function testNamePropertyMayBeAccessedViaMethods()
    {
        $name = 'sitename';
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setName($name);
        $this->assertEquals($name, $dbBackup->getName());
    }

    /**
     * @covers ::getName
     */
    public function testGetNameWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getName();
    }

    /**
     * @covers ::setName
     */
    public function testSetNameWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setName([]);
    }

    /**
     * @covers ::getLink
     * @covers ::setLink
     */
    public function testLinkPropertyMayBeAccessedViaMethods()
    {
        $link = 'http://www.acquia.com/';
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setLink($link);
        $this->assertEquals($link, $dbBackup->getLink());
    }

    /**
     * @covers ::getLink
     */
    public function testGetLinkWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getLink();
    }

    /**
     * @covers ::setLink
     */
    public function testSetLinkWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setLink([]);
    }

    /**
     * @covers ::getPath
     * @covers ::setPath
     */
    public function testPathPropertyMayBeAccessedViaMethods()
    {
        $path = 'backups/user-prod-db-backup.sql.gz';
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setPath($path);
        $this->assertEquals($path, $dbBackup->getPath());
    }

    /**
     * @covers ::setPath
     */
    public function testSetPathWillThrowExceptionIfNotStringOrNull()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setPath([]);
    }

    /**
     * @covers ::getPath
     * @covers ::setPath
     */
    public function testPathPropertyCanBeEmptyString()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setPath('');
        $this->assertEquals('', $dbBackup->getPath());
    }

    /**
     * @covers ::getStarted
     * @covers ::setStarted
     */
    public function testStartedPropertyMayBeAccessedViaMethods()
    {
        $started = 1468218381;
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setStarted($started);
        $this->assertEquals($started, $dbBackup->getStarted());
    }

    /**
     * @covers ::getStarted
     */
    public function testGetStartedWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getStarted();
    }

    /**
     * @covers ::setStarted
     */
    public function testSetStartedWillThrowExceptionIfNotAnInt()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setStarted([]);
    }

    /**
     * @covers ::getCompleted
     * @covers ::setCompleted
     */
    public function testCompletedPropertyMayBeAccessedViaMethods()
    {
        $completed = 1468219381;
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setCompleted($completed);
        $this->assertEquals($completed, $dbBackup->getCompleted());
    }

    /**
     * @covers ::getCompleted
     */
    public function testGetCompletedWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getCompleted();
    }

    /**
     * @covers ::setCompleted
     */
    public function testSetCompletedWillThrowExceptionIfNotAnInt()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setCompleted([]);
    }

    /**
     * @covers ::getDeleted
     * @covers ::setDeleted
     */
    public function testDeletedPropertyMayBeAccessedViaMethods()
    {
        $deleted = 0;
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setDeleted($deleted);
        $this->assertEquals($deleted, $dbBackup->getDeleted());
    }

    /**
     * @covers ::getDeleted
     */
    public function testGetDeletedWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getDeleted();
    }

    /**
     * @covers ::setDeleted
     */
    public function testSetDeletedWillThrowExceptionIfNotAnInt()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setDeleted([]);
    }

    /**
     * @covers ::setDeleted
     */
    public function testSetDeletedWillThrowExceptionIfNotZeroOrOne()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setDeleted(5);
    }

    /**
     * @covers ::getChecksum
     * @covers ::setChecksum
     */
    public function testChecksumPropertyMayBeAccessedViaMethods()
    {
        $checksum = 'a9e3dac5c312f49415b613aff078f5dd';
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setChecksum($checksum);
        $this->assertEquals($checksum, $dbBackup->getChecksum());
    }

    /**
     * @covers ::getChecksum
     */
    public function testGetChecksumWillThrowExceptionIfPropertyNotSet()
    {
        $this->expectException(RuntimeException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getChecksum();
    }

    /**
     * @covers ::setChecksum
     */
    public function testSetChecksumWillThrowExceptionIfNotAString()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setChecksum([]);
    }

    /**
     * @covers ::setChecksum
     */
    public function testSetChecksumWillThrowExceptionIfNull()
    {
        $this->expectException(InvalidArgumentException::class);
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setChecksum(null);
    }
}
