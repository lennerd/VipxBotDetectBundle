<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Adds tagged vipx_bot_detect.metadata.loader services to vipx_bot_detect.metadata.resolver service
 */
class MetadataResolverPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('vipx_bot_detect.metadata.resolver')) {
            return;
        }

        $definition = $container->getDefinition('vipx_bot_detect.metadata.resolver');

        foreach ($container->findTaggedServiceIds('vipx_bot_detect.metadata.loader') as $id => $attributes) {
            $definition->addMethodCall('addLoader', array(new Reference($id)));
        }
    }
}
