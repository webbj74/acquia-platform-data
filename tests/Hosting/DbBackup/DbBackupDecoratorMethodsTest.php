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

use Acquia\Platform\Cloud\Hosting\DbBackup\DbBackupDecoratorMethods;
use Acquia\Platform\Cloud\Hosting\DbBackupInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\DbBackup\DbBackupDecoratorMethods
 */
class DbBackupDecoratorMethodsTest extends TestCase
{
    const TEST_TRAIT = 'Acquia\Platform\Cloud\Hosting\DbBackup\DbBackupDecoratorMethods';
    const TEST_CLASS = 'Acquia\Platform\Cloud\Hosting\DbBackupInterface';

    /**
     * @covers ::getDbBackup
     * @covers ::setDbBackup
     */
    public function testDbBackupDecoratorMethodsMaySetDecoratedDbBackup()
    {
        /** @var DbBackupDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        /** @var DbBackupInterface $mockClass   */
        $mockClass = $this->getMockBuilder(self::TEST_CLASS)->getMock();

        $mockTrait->setDbBackup($mockClass);
        $this->assertEquals($mockClass, $mockTrait->getDbBackup());
    }

    /**
     * @covers ::getId
     * @covers ::getType
     * @covers ::getName
     * @covers ::getLink
     * @covers ::getPath
     * @covers ::getStarted
     * @covers ::getCompleted
     * @covers ::getDeleted
     * @covers ::getChecksum
     * @dataProvider getDbBackupInterfaceGetters
     */
    public function testDbBackupDecoratorMethodsPassesGettersToDbBackup($getter, $expected)
    {
        /** @var DbBackupDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockClass = $this->getMockBuilder(self::TEST_CLASS)
            ->getMock();
        $mockClass->expects($this->once())
            ->method($getter)
            ->willReturn($expected);

        $mockTrait->setDbBackup($mockClass);
        $this->assertEquals($expected, call_user_func([$mockTrait, $getter]));
    }

    /**
     * @covers ::setType
     * @covers ::setName
     * @covers ::setLink
     * @covers ::setPath
     * @covers ::setStarted
     * @covers ::setCompleted
     * @covers ::setDeleted
     * @covers ::setChecksum
     * @dataProvider getDbBackupInterfaceSetters
     */
    public function testDbBackupDecoratorMethodsPassesSettersToDbBackup($setter, $expected)
    {
        /** @var DbBackupDecoratorMethods $mockTrait */
        $mockTrait = $this->getMockForTrait(self::TEST_TRAIT);
        $mockClass = $this->getMockBuilder(self::TEST_CLASS)
            ->getMock();
        $mockClass->expects($this->once())
            ->method($setter)
            ->with($expected);

        $mockTrait->setDbBackup($mockClass);
        call_user_func([$mockTrait, $setter], $expected);
    }

    public function getDbBackupInterfaceGetters()
    {
        return [
            ['getId', 12345678],
            ['getType', 'daily'],
            ['getName', 'mysite'],
            ['getLink', 'http://www.acquia.com/'],
            ['getPath', 'backups/user-prod-db-backup.sql.gz'],
            ['getStarted', 1468218381],
            ['getCompleted', 1468219381],
            ['getDeleted', 0],
            ['getChecksum', 'a9e3dac5c312f49415b613aff078f5dd'],
        ];
    }

    public function getDbBackupInterfaceSetters()
    {
        return [
            ['setType', 'daily'],
            ['setName', 'mysite'],
            ['setLink', 'http://www.acquia.com/'],
            ['setPath', 'backups/user-prod-db-backup.sql.gz'],
            ['setStarted', 1468218381],
            ['setCompleted', 1468219381],
            ['setDeleted', 0],
            ['setChecksum', 'a9e3dac5c312f49415b613aff078f5dd'],
        ];
    }
}
