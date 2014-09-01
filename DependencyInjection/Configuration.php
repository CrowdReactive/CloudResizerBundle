<?php

namespace CrowdReactive\CloudResizerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\NodeInterface;

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
        $builder = new TreeBuilder();
        $rootNode = $builder->root('crowd_reactive_cloud_resizer');

        $rootNode->children()
                ->arrayNode('providers')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->children()
                        ->append($this->addCloudImageProviderNode()->canBeEnabled())
                        ->append($this->addImgixProviderNode()->canBeEnabled())
                        ->append($this->addCustomProviderNode()->canBeEnabled())
                    ->end()
                ->end()
            ->end()

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

        return $builder;
    }

    private function addCloudImageProviderNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('cloudimage');

        $node
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('token')->cannotBeEmpty()->end()
            ->end();

        return $node;
    }

    private function addImgixProviderNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('imgix');

        $node->children()
            ->scalarNode('token')->cannotBeEmpty()->end()
            ->scalarNode('subdomain')->cannotBeEmpty()->end()
            ->end();

        return $node;
    }

    private function addCustomProviderNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('custom');

        $node->children()
            ->scalarNode('service')->cannotBeEmpty()->end()
            ->end();


        return $node;
    }




    // internals

    private function getProviderNames(NodeInterface $tree)
    {
        foreach ($tree->getChildren() as $providers) {
            if ($providers->getName() !== 'providers') {
                continue;
            }

            $children = $providers->getPrototype()->getChildren();
            $providers = array_diff(array_keys($children), ['type']);

            return $providers;
        }

        return [];
    }

    private function isCustomProvider($type, NodeInterface $tree)
    {
        return !in_array($type, $this->getProviderNames($tree));
    }
}
