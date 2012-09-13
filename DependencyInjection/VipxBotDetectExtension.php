<?php

namespace Vipx\BotDetectBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
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
            $container->getDefinition('vipx_bot_detect.security.authentication_listener_listener')->addTag('kernel.event_listener', array(
                'event' => 'kernel.request',
                'method' => 'onKernelRequest',
            ));
        }

        $container->setParameter('vipx_bot_detect.metadata.resource', $config['resource']);
        $container->setParameter('vipx_bot_detect.metadata.cache_file', $config['cache_file']);
    }
}
