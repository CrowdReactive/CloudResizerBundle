<?php

namespace CrowdReactive\CloudResizerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class CrowdReactiveCloudResizerExtension extends Extension
{
    protected $providers = [];

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        /**
         * Create a service definition for each Provider
         */
        foreach ($config['providers'] as $name => $provider) {
            $enabled = 0;
            foreach ($provider as $type => $settings) {
                if (isset($settings['enabled']) && $settings['enabled']) {
                    // Ensure that only one provider is configured
                    if (++$enabled > 1) {
                        throw new \Exception('CloudResizer configuration error: more than one provider configured for '.$name);
                    }

                    // Create a service definition
                    $id = $this->getDefinitionId('provider', $name);
                    $definition = $this->getProviderDefinition($type, $settings, $container);
                    $container->setDefinition($id, $definition);

                    $this->providers[$name] = $id;
                }
            }
        }

        $manager = $container->getDefinition('crowd_reactive_cloud_resizer.service');

        /**
         * Create a service definition for each filter, getting the Filter instance from the Provider service
         * and adding to the manager service
         */
        foreach ($config['filters'] as $name => $info) {
            $id = $this->getDefinitionId('filter', $name);
            $filter = $this->getFilterDefinition($info);
            $container->setDefinition($id, $filter);

            $manager->addMethodCall('setFilter', [$name, $filter]);
        }
    }

    /**
     * Pulls provider classes by their name in the parameter bag
     * @param ContainerBuilder $container
     * @return array
     */
    private function getProviderClassMap(ContainerBuilder $container)
    {
        $pattern = '/'.preg_quote('crowd_reactive_cloud_resizer.provider.', '/').'(\w+)'.preg_quote('.class', '/').'/';
        $map = [];

        foreach ($container->getParameterBag()->all() as $name => $value) {
            if (preg_match($pattern, $name, $matches) == 1) {
                $map[$matches[1]] = $value;
            }
        }

        return $map;
    }

    /**
     * @param $type
     * @param string $name
     * @return string Provider service definition name
     */
    private function getDefinitionId($type, $name)
    {
        return $this->getAlias().'.'.$type.'.'.$name;
    }

    /**
     * Create a service definition for a provider
     * @param $type
     * @param array $options
     * @param ContainerBuilder $container
     * @return Definition
     * @throws \Exception
     */
    private function getProviderDefinition($type, array $options, ContainerBuilder $container)
    {
        static $classMap;
        if (!isset($classMap)) {
            $classMap = $this->getProviderClassMap($container);
        }

        switch ($type) {
            case 'cloudimage':
                return new Definition($classMap['cloudimage'], [$options['token']]);
        }

        throw new \Exception('Unknown CloudResizer provider '.$type);
    }

    private function getFilterDefinition(array $options)
    {
        $filter = new Definition('CrowdReactive\CloudResizer\Filter\FilterInterface');
        $filter->setFactoryService($this->providers[$options['provider']]);
        $filter->setFactoryMethod('getFilterInstance');
        $filter->addMethodCall('setParameters', [$options['parameters']]);

        return $filter;
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'crowd_reactive_cloud_resizer';
    }
}
