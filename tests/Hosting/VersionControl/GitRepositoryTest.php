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
use Acquia\Platform\Cloud\Hosting\VersionControl\GitRepository;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\VersionControl\GitRepository
 */
class GitRepositoryTest extends TestCase
{
    const GIT_REPO_URL = 'sample@vcs-123.test:sample.git';
    const GIT_REPO_BRANCH = 'testbranch';

    /**
     * @covers ::getCheckoutCommand
     * @dataProvider checkoutDataProvider
     */
    public function testReturnsCheckoutCommand($environment, $destination, $expected)
    {
        $application = $this->getApplication();
        $repo = new GitRepository($application, $environment);
        $this->assertEquals($expected, $repo->getCheckoutCommand($destination));
    }

    /**
     * @covers ::getBranchListCommand
     * @dataProvider branchDataProvider
     */
    public function testReturnsBranchListCommand($environment, $expected)
    {
        $application = $this->getApplication();
        $repo = new GitRepository($application, $environment);
        $this->assertEquals($expected, $repo->getBranchListCommand());
    }


    /**
     * @covers ::getTagListCommand
     * @dataProvider tagDataProvider
     */
    public function testReturnsTagListCommand($environment, $expected)
    {
        $application = $this->getApplication();
        $repo = new GitRepository($application, $environment);
        $this->assertEquals($expected, $repo->getTagListCommand());
    }


    /**
     * @covers ::getHistoryCommand
     * @dataProvider historyDataProvider
     */
    public function testReturnsHistoryCommand($environment, $expected)
    {
        $application = $this->getApplication();
        $repo = new GitRepository($application, $environment);
        $this->assertEquals($expected, $repo->getHistoryCommand());
    }

    protected function getApplication()
    {
        $app = new Application('test');
        $app->setVcsRepositoryUrl(self::GIT_REPO_URL);
        return $app;
    }

    protected function getEnvironment()
    {
        $env = new Environment('test');
        $env->setMachineName('teststg');
        $env->setRevision(self::GIT_REPO_BRANCH);
        return $env;
    }

    public function checkoutDataProvider()
    {
        $env = $this->getEnvironment();
        return [
            'no environment, no destination' => [null, '', 'git clone sample@vcs-123.test:sample.git '],
            'no environment, destination' => [null, 'dest', 'git clone sample@vcs-123.test:sample.git dest'],
            'environment, no destination' => [$env, '', 'git clone -b testbranch sample@vcs-123.test:sample.git '],
            'environment, destination' => [$env, 'dest', 'git clone -b testbranch sample@vcs-123.test:sample.git dest'],
        ];
    }

    public function branchDataProvider()
    {
        $env = $this->getEnvironment();
        return [
            'no environment' => [null, 'git ls-remote --heads sample@vcs-123.test:sample.git'],
            'environment' => [$env, 'git ls-remote --heads sample@vcs-123.test:sample.git'],
        ];
    }

    public function tagDataProvider()
    {
        $env = $this->getEnvironment();
        return [
            'no environment' => [null, 'git ls-remote --tags sample@vcs-123.test:sample.git'],
            'environment' => [$env, 'git ls-remote --tags sample@vcs-123.test:sample.git'],
        ];
    }

    public function historyDataProvider()
    {
        $env = $this->getEnvironment();
        return [
            'no environment' => [null, 'git log -10'],
            'environment' => [$env, 'git log -10'],
        ];
    }
}
