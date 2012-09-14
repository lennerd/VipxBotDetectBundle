<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Tests\Bot\Loader;

use Vipx\BotDetectBundle\Bot\Metadata\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Vipx\BotDetectBundle\Bot\Metadata\Metadata;

class YamlFileLoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testSupport()
    {
        $locator = new FileLocator();
        $loader = new YamlFileLoader($locator);

        $this->assertTrue($loader->supports('test.yml'));
        $this->assertFalse($loader->supports('test.xml'));
    }

    public function testParsing()
    {
        $locator = new FileLocator();
        $loader = new YamlFileLoader($locator);
        $metadataFile = __DIR__ . '/../../../Resources/metadata/extended.yml';

        $metadatas = $loader->load($metadataFile)->getMetadatas();

        $this->assertArrayHasKey('Google', $metadatas);
        $this->assertArrayHasKey('vectra-mods', $metadatas);

        /** @var $metadata \Vipx\BotDetectBundle\Bot\Metadata\Metadata */
        $metadata = $metadatas['Google'];

        $this->assertEquals('Googlebot', $metadata->getAgent());
        $this->assertEquals(null, $metadata->getIp());
        $this->assertEquals(Metadata::TYPE_BOT, $metadata->getType());

        /** @var $metadata \Vipx\BotDetectBundle\Bot\Metadata\Metadata */
        $metadata = $metadatas['vectra-mods'];

        $this->assertEquals('', $metadata->getAgent());
        $this->assertEquals('212.227.101.211', $metadata->getIp());
        $this->assertEquals(Metadata::TYPE_SPAMBOT, $metadata->getType());
    }

}
