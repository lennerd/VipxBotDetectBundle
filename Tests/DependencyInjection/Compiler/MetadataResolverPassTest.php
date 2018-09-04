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

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Vipx\BotDetectBundle\DependencyInjection\Compiler\MetadataResolverPass;

class MetadataResolverPassTest extends TestCase
{

    const SERVICE_ID = 'test_service';

    public function testAddingTaggedServices()
    {
        $resolverPass = new MetadataResolverPass();
        $containerBuilder = new ContainerBuilder();

        $resolverService = new Definition();

        $taggedService = new Definition();
        $taggedService->addTag('vipx_bot_detect.metadata.loader');

        $containerBuilder->addDefinitions(array(
            'vipx_bot_detect.metadata.resolver' => $resolverService,
            self::SERVICE_ID => $taggedService
        ));

        $resolverPass->process($containerBuilder);

        $this->assertTrue($resolverService->hasMethodCall('addLoader'));

        $methodsCalls = $resolverService->getMethodCalls();
        /** @var $reference Reference */
        $reference = $methodsCalls[0][1][0];

        $this->assertEquals(self::SERVICE_ID, (string) $reference);
    }

}
