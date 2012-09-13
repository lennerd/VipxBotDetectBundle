<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Adds tagged routing.loader services to routing.resolver service
 *
 * @author Fabien Potencier <fabien@symfony.com>
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
