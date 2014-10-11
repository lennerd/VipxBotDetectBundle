<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class VipxBotDetectExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ($config['use_listener']) {
            $listenerDefinition = $container->getDefinition('vipx_bot_detect.security.authentication_listener');

            $listenerDefinition->setPublic(true);
            $listenerDefinition->addTag('kernel.event_listener', array(
                'event' => 'kernel.request',
                'method' => 'onKernelRequest',
            ));
        }

        $container->setParameter('vipx_bot_detect.metadata.metadata_file', $config['metadata_file']);
        $container->setParameter('vipx_bot_detect.metadata.cache_file', $config['cache_file']);
    }
}
