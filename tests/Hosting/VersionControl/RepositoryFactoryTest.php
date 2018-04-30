<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Hosting\VersionControl;

use Acquia\Platform\Cloud\Hosting\Application;
use Acquia\Platform\Cloud\Hosting\VersionControl\RepositoryFactory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\VersionControl\RepositoryFactory
 */
class RepositoryFactoryTest extends TestCase
{
    /**
     * @covers ::getRepository
     */
    public function testFactoryCanProduceGitRepository()
    {
        $application = new Application('test');
        $application->setVcsRepositoryUrl(GitRepositoryTest::GIT_REPO_URL);
        $this->assertInstanceOf(
            "Acquia\\Platform\\Cloud\\Hosting\\VersionControl\\GitRepository",
            RepositoryFactory::getRepository($application, null)
        );
    }

    /**
     * @covers ::getRepository
     */
    public function testFactoryCanProduceSubversionRepository()
    {
        $application = new Application('test');
        $application->setVcsRepositoryUrl(SubversionRepositoryTest::SVN_REPO_URL);
        $this->assertInstanceOf(
            "Acquia\\Platform\\Cloud\\Hosting\\VersionControl\\SubversionRepository",
            RepositoryFactory::getRepository($application, null)
        );
    }

    /**
     * @covers ::getRepository
     * @expectedException \RuntimeException
     */
    public function testFactoryThrowsExceptionForUnknownRepository()
    {
        $application = new Application('test');
        $application->setVcsRepositoryUrl(':pserver:sample@svn-123.test:/cvs/sample');
        RepositoryFactory::getRepository($application, null);
    }
}
