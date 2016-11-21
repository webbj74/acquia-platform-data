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
use Acquia\Platform\Cloud\Hosting\Environment;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\VersionControl\Repository
 */
class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    protected function getConcreteRepository()
    {
        $application = new Application('test');
        $application->setVcsRepositoryUrl(GitRepositoryTest::GIT_REPO_URL);

        $environment = new Environment('test');
        $environment->setMachineName('teststg');
        $environment->setRevision(GitRepositoryTest::GIT_REPO_BRANCH);

        /** @var \Acquia\Platform\Cloud\Hosting\VersionControl\Repository $repo */
        $repo = $this->getMockForAbstractClass(
            'Acquia\Platform\Cloud\Hosting\VersionControl\Repository',
            [$application, $environment]
        );
        return $repo;
    }

    /**
     * @covers ::getUrl
     * @covers ::__construct
     */
    public function testRepositoryReturnsUrl()
    {
        $repo = $this->getConcreteRepository();
        $this->assertEquals(GitRepositoryTest::GIT_REPO_URL, $repo->getUrl());
    }

    /**
     * @covers ::formatRevisionString
     */
    public function testRepositoryReturnsFormattedRevision()
    {
        $repo = $this->getConcreteRepository();
        $this->assertEquals(
            GitRepositoryTest::GIT_REPO_URL . "  " . GitRepositoryTest::GIT_REPO_BRANCH,
            $repo->formatRevisionString()
        );
    }
}
