<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Tests\DependencyInjection;

use Vipx\BotDetectBundle\DependencyInjection\VipxBotDetectExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class VipxBotDetectExtensionTest extends \PHPUnit_Framework_TestCase
{

    const METADATA_FILE = 'test_metadata_file';
    const CACHE_FILE = 'test_cache_file';

    public function testListenerExtension()
    {
        $extension = new VipxBotDetectExtension();
        $containerBuilder = $this->getContainerBuilder();

        $extension->load($this->getConfig(), $containerBuilder);
        $definition = $containerBuilder->getDefinition('vipx_bot_detect.security.authentication_listener');

        $this->assertTrue($definition->hasTag('kernel.event_listener'));
        $this->assertTrue($definition->isPublic());

        $eventTag = $definition->getTag('kernel.event_listener');

        $this->assertEquals(array(
            'event' => 'kernel.request',
            'method' => 'onKernelRequest',
        ), $eventTag[0]);
    }

    public function testParameters()
    {
        $extension = new VipxBotDetectExtension();
        $containerBuilder = $this->getContainerBuilder();

        $extension->load($this->getConfig(), $containerBuilder);

        $this->assertTrue($containerBuilder->hasParameter('vipx_bot_detect.metadata.metadata_file'));
        $this->assertTrue($containerBuilder->hasParameter('vipx_bot_detect.metadata.cache_file'));

        $this->assertEquals(self::METADATA_FILE, $containerBuilder->getParameter('vipx_bot_detect.metadata.metadata_file'));
        $this->assertEquals(self::CACHE_FILE, $containerBuilder->getParameter('vipx_bot_detect.metadata.cache_file'));
    }

    private function getConfig()
    {
        return array(
            'vipx_bot_detect' => array(
                'use_listener' => true,
                'metadata_file' => self::METADATA_FILE,
                'cache_file' => self::CACHE_FILE,
            ),
        );
    }

    private function getContainerBuilder()
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions(array(
            'vipx_bot_detect.security.authentication_listener' => new Definition(),
        ));

        return $containerBuilder;
    }

}
