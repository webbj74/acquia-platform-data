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
use Acquia\Platform\Cloud\Hosting\VersionControl\SubversionRepository;

/**
 * @coversDefaultClass \Acquia\Platform\Cloud\Hosting\VersionControl\SubversionRepository
 */
class SubversionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    const SVN_REPO_URL = 'https://svn-123.test/sample';
    const SVN_REPO_BRANCH = 'testbranch';

    /**
     * @covers ::getCheckoutCommand
     * @dataProvider checkoutDataProvider
     */
    public function testReturnsCheckoutCommand($environment, $destination, $expected)
    {
        $application = $this->getApplication();
        $repo = new SubversionRepository($application, $environment);
        $this->assertEquals($expected, $repo->getCheckoutCommand($destination));
    }

    /**
     * @covers ::getBranchListCommand
     * @dataProvider branchDataProvider
     */
    public function testReturnsBranchListCommand($environment, $expected)
    {
        $application = $this->getApplication();
        $repo = new SubversionRepository($application, $environment);
        $this->assertEquals($expected, $repo->getBranchListCommand());
    }


    /**
     * @covers ::getTagListCommand
     * @dataProvider tagDataProvider
     */
    public function testReturnsTagListCommand($environment, $expected)
    {
        $application = $this->getApplication();
        $repo = new SubversionRepository($application, $environment);
        $this->assertEquals($expected, $repo->getTagListCommand());
    }


    /**
     * @covers ::getHistoryCommand
     * @dataProvider historyDataProvider
     */
    public function testReturnsHistoryCommand($environment, $expected)
    {
        $application = $this->getApplication();
        $repo = new SubversionRepository($application, $environment);
        $this->assertEquals($expected, $repo->getHistoryCommand());
    }

    /**
     * @covers ::formatRevisionString
     */
    public function testRepositoryReturnsFormattedRevision()
    {
        $application = $this->getApplication();
        $repo = new SubversionRepository($application, null);
        $this->assertEquals(
            self::SVN_REPO_URL . '/',
            $repo->formatRevisionString()
        );
        $repo = new SubversionRepository($application, $this->getEnvironment());
        $this->assertEquals(
            self::SVN_REPO_URL . '/' . self::SVN_REPO_BRANCH,
            $repo->formatRevisionString()
        );
    }

    protected function getApplication()
    {
        $app = new Application('test');
        $app->setVcsRepositoryUrl(self::SVN_REPO_URL);
        return $app;
    }

    protected function getEnvironment()
    {
        $env = new Environment('test');
        $env->setMachineName('teststg');
        $env->setRevision(self::SVN_REPO_BRANCH);
        return $env;
    }

    public function checkoutDataProvider()
    {
        $env = $this->getEnvironment();
        return [
            'no environment, no destination' => [null, '', 'svn checkout https://svn-123.test/sample/trunk '],
            'no environment, destination' => [null, 'dest', 'svn checkout https://svn-123.test/sample/trunk dest'],
            'environment, no destination' => [$env, '', 'svn checkout https://svn-123.test/sample/testbranch '],
            'environment, destination' => [$env, 'dest', 'svn checkout https://svn-123.test/sample/testbranch dest'],
        ];
    }

    public function branchDataProvider()
    {
        $env = $this->getEnvironment();
        return [
            'no environment' => [null, 'svn list https://svn-123.test/sample/branches'],
            'environment' => [$env, 'svn list https://svn-123.test/sample/branches'],
        ];
    }

    public function tagDataProvider()
    {
        $env = $this->getEnvironment();
        return [
            'no environment' => [null, 'svn list https://svn-123.test/sample/tags'],
            'environment' => [$env, 'svn list https://svn-123.test/sample/tags'],
        ];
    }

    public function historyDataProvider()
    {
        $env = $this->getEnvironment();
        return [
            'no environment' => [null, 'svn log --limit 10'],
            'environment' => [$env, 'svn log --limit 10'],
        ];
    }
}
