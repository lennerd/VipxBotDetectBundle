<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpFoundation\Request;
use Vipx\BotDetect\Metadata\Metadata;
use Vipx\BotDetect\Metadata\MetadataCollection;
use Vipx\BotDetect\Metadata\MetadataInterface;
use Vipx\BotDetectBundle\BotDetector;

class BotDetectorTest extends TestCase
{
    private $loader;
    private $metadataCollection;

    public function testDetectBotFromRequest()
    {
        $request = new Request(array(), array(), array(), array(), array(), array(
            'HTTP_USER_AGENT' => 'Googlebot',
            'REMOTE_ADDR' => '127.0.0.1',
        ));

        $detector = $this->createDetector();

        $this->assertInstanceOf(
            MetadataInterface::class,
            $detector->detectFromRequest($request)
        );
    }

    private function createDetector()
    {
        return new BotDetector($this->getLoader(), '/my/vipx/bot/file.yml');
    }

    private function getLoader()
    {
        if (null === $this->loader) {
            /** @var LoaderInterface|MockObject $loader */
            $loader = $this->getMockBuilder(LoaderInterface::class)
                ->getMock();

            $loader->expects($this->any())
                ->method('load')
                ->will($this->returnValue($this->getMetadataCollection()));

            $this->loader = $loader;
        }

        return $this->loader;
    }

    private function getMetadataCollection()
    {
        if (null === $this->metadataCollection) {
            $googleBot = new Metadata('Googlebot', 'Googlebot', '127.0.0.1');

            $metadatas = array(
                $googleBot,
            );

            $this->metadataCollection = $this->getMockBuilder(MetadataCollection::class)
                ->getMock();

            $this->metadataCollection->expects($this->any())
                ->method('getIterator')
                ->will($this->returnCallback(function() use ($metadatas) {
                    return new \ArrayIterator($metadatas);
                }));

            $this->metadataCollection->expects($this->any())
                ->method('getMetadatas')
                ->willReturn($metadatas);
        }

        return $this->metadataCollection;
    }
}