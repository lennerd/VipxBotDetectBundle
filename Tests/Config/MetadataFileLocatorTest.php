<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Tests\Config;

use PHPUnit\Framework\TestCase;
use Vipx\BotDetectBundle\Config\MetadataFileLocator;

class MetadataFileLocatorTest extends TestCase
{

    public function testLocate()
    {
        $fileLocator = $this->getFileLocator();

        $this->assertFileExists($fileLocator->locate('extended.yml'));
    }

    private function getFileLocator()
    {
        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\KernelInterface')->getMock();

        return new MetadataFileLocator($kernel);
    }

}
