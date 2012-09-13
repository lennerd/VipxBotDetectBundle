<?php

namespace Vipx\BotDetectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('vipx_bot_detect');

        $rootNode->children()
            ->scalarNode('resource')->defaultValue('@VipxBotDetectBundle/Resources/metadata/basic.yml')->end()
            ->scalarNode('cache_file')->defaultValue('project_vipx_bot_detect_metadata.php')->end()
            ->booleanNode('use_listener')->defaultValue(false)->end()
        ->end();

        return $treeBuilder;
    }
}
