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

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\DbBackup
 */
class DbBackupTest extends \PHPUnit_Framework_TestCase
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
     * @expectedException \InvalidArgumentException
     */
    public function testIdPropertyMustBeAnInt()
    {
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
     * @expectedException \RuntimeException
     */
    public function testGetTypeWillThrowExceptionIfPropertyNotSet()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getType();
    }

    /**
     * @covers ::setType
     * @expectedException \InvalidArgumentException
     */
    public function testSetTypeWillThrowExceptionIfNotAString()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setType([]);
    }

    /**
     * @covers ::setType
     * @expectedException \InvalidArgumentException
     */
    public function testSetTypeWillThrowExceptionIfEmptyString()
    {
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
     * @expectedException \RuntimeException
     */
    public function testGetNameWillThrowExceptionIfPropertyNotSet()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getName();
    }

    /**
     * @covers ::setName
     * @expectedException \InvalidArgumentException
     */
    public function testSetNameWillThrowExceptionIfNotAString()
    {
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
     * @expectedException \RuntimeException
     */
    public function testGetLinkWillThrowExceptionIfPropertyNotSet()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getLink();
    }

    /**
     * @covers ::setLink
     * @expectedException \InvalidArgumentException
     */
    public function testSetLinkWillThrowExceptionIfNotAString()
    {
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
     * @covers ::getPath
     * @expectedException \RuntimeException
     */
    public function testGetPathWillThrowExceptionIfPropertyNotSet()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getPath();
    }

    /**
     * @covers ::setPath
     * @expectedException \InvalidArgumentException
     */
    public function testSetPathWillThrowExceptionIfNotAString()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setPath([]);
    }

    /**
     * @covers ::setPath
     * @expectedException \InvalidArgumentException
     */
    public function testSetPathWillThrowExceptionIfEmptyString()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setPath('');
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
     * @expectedException \RuntimeException
     */
    public function testGetStartedWillThrowExceptionIfPropertyNotSet()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getStarted();
    }

    /**
     * @covers ::setStarted
     * @expectedException \InvalidArgumentException
     */
    public function testSetStartedWillThrowExceptionIfNotAnInt()
    {
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
     * @expectedException \RuntimeException
     */
    public function testGetCompletedWillThrowExceptionIfPropertyNotSet()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getCompleted();
    }

    /**
     * @covers ::setCompleted
     * @expectedException \InvalidArgumentException
     */
    public function testSetCompletedWillThrowExceptionIfNotAnInt()
    {
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
     * @expectedException \RuntimeException
     */
    public function testGetDeletedWillThrowExceptionIfPropertyNotSet()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getDeleted();
    }

    /**
     * @covers ::setDeleted
     * @expectedException \InvalidArgumentException
     */
    public function testSetDeletedWillThrowExceptionIfNotAnInt()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setDeleted([]);
    }

    /**
     * @covers ::setDeleted
     * @expectedException \InvalidArgumentException
     */
    public function testSetDeletedWillThrowExceptionIfNotZeroOrOne()
    {
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
     * @expectedException \RuntimeException
     */
    public function testGetChecksumWillThrowExceptionIfPropertyNotSet()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->getChecksum();
    }

    /**
     * @covers ::setChecksum
     * @expectedException \InvalidArgumentException
     */
    public function testSetChecksumWillThrowExceptionIfNotAString()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setChecksum([]);
    }

    /**
     * @covers ::setChecksum
     * @expectedException \InvalidArgumentException
     */
    public function testSetChecksumWillThrowExceptionIfEmptyString()
    {
        $dbBackup = new DbBackup(12345678);
        $dbBackup->setChecksum('');
    }
}
