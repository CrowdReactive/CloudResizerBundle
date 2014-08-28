<?php

namespace CrowdReactive\CloudResizerBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('crowd_reactive_cloud_resizer');

        $rootNode->children()
            // array of services
            ->arrayNode('filters')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->children()
                        ->scalarNode('name')->cannotBeEmpty()->end()
                        // a service name
                        ->scalarNode('provider')->cannotBeEmpty()->end()
                        // filter parameters
                        ->variableNode('parameters')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
